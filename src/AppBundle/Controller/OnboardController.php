<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CorporateProfile;
use AppBundle\Entity\Individual;
use AppBundle\Entity\Onboard;
use AppBundle\Entity\Profile;
use AppBundle\Entity\User;
use AppBundle\Form\CorporateForm;
use AppBundle\Form\IndividualForm;
use AppBundle\Form\OnboardForm;
use AppBundle\Form\RegistrationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OnboardController extends Controller
{
    /**
     * @Route("/",name="onboard")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(RegistrationForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setIsActive(true);
            $user->setRoles(["ROLE_USER"]);
            if ($user->getUserType() == "Individual") {
                $profile = new Profile();
                $profile->setApplicantName($user->getFirstName() . ' ' . $user->getMiddleName() . ' ' . $user->getLastName());
                $profile->setProducerName($user->getFirstName() . ' ' . $user->getMiddleName() . ' ' . $user->getLastName());
                $profile->setCreatedAt(new \DateTime());
                $profile->setEmailAddress($user->getEmail());
                $profile->setMobileNumber($user->getPhoneNumber());
                $user->setProfile($profile);
                $em->persist($profile);
                $em->persist($user);
                $em->flush();
                $this->sendWelcomeEmail($user->getfirstName(), $user->getEmail());

            } elseif ($user->getUserType() == "Deceased Producer") {
                $profile = new Profile();
                $profile->setApplicantName($user->getFirstName() . ' ' . $user->getMiddleName() . ' ' . $user->getLastName());
                $profile->setProducerName($request->request->get('producerNames'));
                $profile->setProducerRelationship($request->request->get('producerRelationship'));
                $profile->setKinFirstName($user->getFirstName());
                $profile->setKinMiddleName($user->getMiddleName());
                $profile->setKinLastName($user->getMiddleName());
                $profile->setCreatedAt(new \DateTime());
                $profile->setEmailAddress($user->getEmail());
                $profile->setMobileNumber($user->getPhoneNumber());
                $user->setProfile($profile);
                $em->persist($profile);
                $em->persist($user);
                $em->flush();

                //$this->sendWelcomeEmail($user->getfirstName(),$user->getEmail());
            } else {
                $corporateProfile = new CorporateProfile();
                $corporateProfile->setEmailAddress($user->getEmail());
                $corporateProfile->setCreatedAt(new \DateTime());
                $corporateProfile->setCompanyType($user->getUserType());
                $corporateProfile->setFirstDirectorNames($user->getFirstName() . ' ' . $user->getMiddleName() . ' ' . $user->getLastName());
                $corporateProfile->setMobileNumber($user->getPhoneNumber());
                $corporateProfile->setCompanyName($request->request->get('companyName'));
                $user->setCorporateProfile($corporateProfile);
                $em->persist($corporateProfile);
                $em->persist($user);
                $em->flush();

                // $this->sendWelcomeEmail($corporateProfile->getfirstDirectorNames(),$corporateProfile->getEmailAddress());
            }
            return $this->redirectToRoute('onboarded');


        }
        return $this->render('onboard/register.htm.twig', ['onboardForm' => $form->createView()]);
    }

    /**
     * @Route("/start/individual",name="onboard-individual")
     */
    public function individualAction(Request $request)
    {
        $individual = new Individual();
        $individual->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(IndividualForm::class, $individual);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $onboard = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($onboard);
            $em->flush();
            $this->sendIndividualWelcomeEmail($onboard->getfirstName(), $onboard->getEmail(), $onboard->getId());
            return $this->redirectToRoute('onboarded');
        } else {
            $errors = $form->getErrors();
        }
        return $this->render('onboard/onboard.htm.twig', ['onboardForm' => $form->createView()]);
    }

    /**
     * @Route("/start/corporate",name="onboard-corporate")
     */
    public function corporateAction(Request $request)
    {
        $onboard = new Onboard();
        $onboard->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(CorporateForm::class, $onboard);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $onboard = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($onboard);
            $em->flush();
            $this->sendWelcomeEmail($onboard->getfirstDirectorNames(), $onboard->getEmail(), $onboard->getId());
            return $this->redirectToRoute('onboarded');
        } else {
            $errors = $form->getErrors();
        }
        return $this->render('onboard/corporate.htm.twig', ['onboardForm' => $form->createView()]);
    }

    /**
     * @Route("/onboarded",name="onboarded")
     */
    public function onboardedAction()
    {
        return $this->render('onboard/onboarded.htm.twig');
    }

    /**
     * @Route("/mpesa/update/{transactionId}",name="update-mpesa")
     */
    public function mpesaPaymentSuccessAction(Request $request, $transactionId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AppBundle:Profile")->findOneBy(['referenceId' => $transactionId]);
        if ($user) {
            $data = json_decode(file_get_contents('php://input'), true);
            $resultCode = $data['Body']['stkCallback']['ResultCode'];
            $resultDesc = $data['Body']['stkCallback']['ResultDesc'];
            $user->setMpesaDescription($resultDesc);
            $transactionArray = array();
            if ($resultCode == 0) {
                $item = $data['Body']['stkCallback']['CallbackMetadata']['Item'];
                $amount = $item[0]['Value'];
                $mpesaCode = $item[1]['Value'];
                $transDate = $item[3]['Value'];
                $phoneNumber = $item[4]['Value'];
                $user->setMpesaProcessed(true);
                $user->setMpesaAmount($amount);
                $user->setMpesaVerificationCode($mpesaCode);
                $user->setMpesaStatus('Success');
                $user->setMpesaNumber($phoneNumber);
                $user->setIsPaid(true);
                $user->setMpesaPaymentDate(new \DateTime());
                $transactionArray = array("a" => $mpesaCode, "b" => $transDate, "c" => $phoneNumber, "d" => $amount);

            } elseif ($resultCode == 1032) {
                $user->setMpesaStatus("Cancelled");
                $user->setIsPaid(false);
                $user->setMpesaProcessed(true);
            } else {
                $user->setMpesaStatus("Failed");
                $user->setIsPaid(false);
                $user->setMpesaProcessed(true);
            }
            $em->persist($user);
            $em->flush();
            if ($resultCode == 0) {
                $this->sendPaymentEmail($user->getFirstName(), $user->getEmailAddress(), $transactionArray);
            }
        } else {
            $user = $em->getRepository("AppBundle:CorporateProfile")->findOneBy(['referenceId' => $transactionId]);
            $data = json_decode(file_get_contents('php://input'), true);
            $resultCode = $data['Body']['stkCallback']['ResultCode'];
            $resultDesc = $data['Body']['stkCallback']['ResultDesc'];
            $user->setMpesaDescription($resultDesc);
            $transactionArray = array();
            if ($resultCode == 0) {
                $item = $data['Body']['stkCallback']['CallbackMetadata']['Item'];
                $amount = $item[0]['Value'];
                $mpesaCode = $item[1]['Value'];
                $transDate = $item[3]['Value'];
                $phoneNumber = $item[4]['Value'];
                $user->setMpesaProcessed(true);
                $user->setMpesaAmount($amount);
                $user->setMpesaVerificationCode($mpesaCode);
                $user->setMpesaStatus('Success');
                $user->setMpesaNumber($phoneNumber);
                $user->setIsPaid(true);
                $user->setMpesaPaymentDate(new \DateTime());
                $transactionArray = array("a" => $mpesaCode, "b" => $transDate, "c" => $phoneNumber, "d" => $amount);

            } elseif ($resultCode == 1032) {
                $user->setMpesaStatus("Cancelled");
                $user->setIsPaid(false);
                $user->setMpesaProcessed(true);
            } else {
                $user->setMpesaStatus("Failed");
                $user->setIsPaid(false);
                $user->setMpesaProcessed(true);
            }
            $em->persist($user);
            $em->flush();
            if ($resultCode == 0) {
                $this->sendPaymentEmail($user->getFirstName(), $user->getEmailAddress(), $transactionArray);
            }
        }
        return new Response(null, 200);
    }

    public function sendWelcomeEmail($firstName, $emailAddress)
    {
        $message = \Swift_Message::newInstance()->setSubject('KAMP Online Portal Registration')->setFrom('kamp@patchcreate.com', 'KAMP Online Portal Team')->setTo($emailAddress)->setBody($this->renderView(// app/Resources/views/Emails/onboard.htm.twig
                'Emails/corporate.htm.twig', array('name' => $firstName,)), 'text/html');
        $this->get('mailer')->send($message);
    }

    public function sendIndividualWelcomeEmail($firstName, $emailAddress, $code)
    {
        $message = \Swift_Message::newInstance()->setSubject('KAMP Online Portal Registration')->setFrom('kamp@patchcreate.com', 'KAMP Online Portal Team')->setTo($emailAddress)->setBody($this->renderView(// app/Resources/views/Emails/onboard.htm.twig
                'Emails/onboard.htm.twig', array('name' => $firstName, 'code' => $code)), 'text/html');
        $this->get('mailer')->send($message);
    }
    public function sendPaymentEmail($firstName, $emailAddress, $code)
    {
        $message = \Swift_Message::newInstance()->setSubject('KAMP Online Portal Profile')->setFrom('kamp@patchcreate.com', 'KAMP Online Portal Team')->setTo($emailAddress)->setBody($this->renderView(// app/Resources/views/Emails/onboard.htm.twig
            'Emails/paid.htm.twig', array('name' => $firstName, 'code' => $code)), 'text/html');
        $this->get('mailer')->send($message);
    }

}
