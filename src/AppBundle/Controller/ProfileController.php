<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CorporateProfile;
use AppBundle\Entity\Documents;
use AppBundle\Entity\Individual;
use AppBundle\Entity\Music;
use AppBundle\Entity\Onboard;
use AppBundle\Entity\Profile;
use AppBundle\Form\CorporateProfileForm;
use AppBundle\Form\DocumentsFormType;
use AppBundle\Form\MpesaFormType;
use AppBundle\Form\NewRecordingForm;
use AppBundle\Form\ProfileForm;
use Crysoft\MpesaBundle\Helpers\Mpesa;
use Crysoft\MpesaBundle\Helpers\Mpesax;
use Crysoft\MpesaBundle\Helpers\MpesaStatus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    /**
     * @Route("/profile/updated",name="profile_updated")
     */
    public function profileCompleteAction()
    {
        return $this->render('profile/updated.htm.twig');
    }

    /**
     * @Route("/profile/{id}/update")
     */
    public function profileAction(Request $request, Individual $individual)
    {
        $profile = new Profile();
        $profile->setApplicantName($individual->getFirstName().' '.$individual->getLastName());
        $profile->setIdNumber($individual->getIdNumber());
        $profile->setEmailAddress($individual->getEmail());
        $profile->setProfileStatus("Pending");
        $profile->setCreatedAt(new \DateTimeImmutable());

         $form = $this->createForm(ProfileForm::class, $profile);


        $form->handleRequest($request);
        if ($form->isValid()) {
            $profile = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $payment = $request->request->get('payment');
            $em->persist($profile);
            $em->flush();
            if ($payment == 'pay') {
        //        $this->sendWelcomeEmail($onboard->getfirstName(), $onboard->getEmail(), $onboard->getId());
                $this->container->get('session')->set('profile', $profile->getId());
                $this->container->get('session')->set('type','user');

                return $this->redirectToRoute('pay_mpesa');

            } else {
      //          $this->sendUnpaidWelcomeEmail($onboard->getfirstName(), $onboard->getEmail(), $onboard->getId());
                return $this->redirectToRoute('profile_updated', array('profileId' => $profile->getId()));
            }
        } else {
            $errors = $form->getErrors();
        }
            return $this->render(':profile:new.htm.twig', [
                'profileForm' => $form->createView(),
                'profile' => $profile,
                'errors' => $errors
            ]);

    }
    /**
     * @Route("/corporate/{id}/update",name="update-profile")
     */
    public function corporateProfileAction(Request $request, Onboard $onboard)
    {
        $profile = new CorporateProfile();
        $profile->setCompanyType($onboard->getCompanyType());
        $profile->setCompanyName($onboard->getCompanyName());
        $profile->setFirstDirectorNames($onboard->getFirstDirectorNames());
        $profile->setFirstDirectorIdNumber($onboard->getFirstDirectorId());
        $profile->setEmailAddress($onboard->getEmail());
        $profile->setProfileStatus("Pending");
        $profile->setRegistrationDate(new \DateTime());
        $profile->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(CorporateProfileForm::class, $profile);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $profile = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $payment = $request->request->get('payment');
            $em->persist($profile);
            $em->flush();
            if ($payment == 'pay') {
                $this->sendWelcomeEmail($onboard->getFirstDirectorNames(), $onboard->getEmail(), $onboard->getId());
                $this->container->get('session')->set('profile', $profile->getId());
                $this->container->get('session')->set('type','corporate');
                return $this->redirectToRoute('pay_mpesa');

            } else {
                //          $this->sendUnpaidWelcomeEmail($onboard->getfirstName(), $onboard->getEmail(), $onboard->getId());
                return $this->redirectToRoute('profile_updated', array('profileId' => $profile->getId()));
            }
        } else {
            $errors = $form->getErrors();
        }
            return $this->render(':profile:newCorporate.htm.twig', [
                'profileForm' => $form->createView(),
                'profile' => $profile,
                'errors' => $errors
            ]);

        }

    /**
     * @Route("/profile/mpesa/pay",name="pay_mpesa")
     */
    public function mpesaPayAction(Request $request)
    {
        $profile = $this->container->get('session')->get('profile');
        $type = $this->container->get('session')->get('type');
        $em = $this->getDoctrine()->getManager();
        if ($type=="corporate") {
            $userProfile = $em->getRepository("AppBundle:CorporateProfile")->findOneBy(['id' => $profile]);
        }else{
            $userProfile = $em->getRepository("AppBundle:Profile")->findOneBy(['id' => $profile]);
        }
       // var_dump($type);exit;
        $form = $this->createForm(MpesaFormType::class, $userProfile);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           // $this->container->get('session')->set('profile', $userProfile);
            $amount = 10;
            $phoneNumber = $form["mobileNumber"]->getData();
            if ($type=="corporate") {
                $referenceId=$userProfile->getFirstDirectorIdNumber();
            }else{
                $referenceId=$userProfile->getIdNumber();
            }
            //$referenceId = $userProfile->getIdNumber();
            $mpesa = new Mpesa($this->container);
            $transactionId = $mpesa->generateTransactionNumber();
            $this->container->get('session')->set('transactionId',$transactionId);

            $response = $mpesa->request($amount)->from($phoneNumber)->usingReferenceId($referenceId)->usingTransactionId($transactionId)->transact();
            return $this->redirectToRoute('mpesa_paid');


        }
        return $this->render('profile/pay.htm.twig', ['profile' => $userProfile, 'mpesaForm' => $form->createView()]);
    }


    /**
     * @Route("/profile/mpesa/complete-payment",name="mpesa_paid")
     */
    public function paySuccessAction(Request $request)
    {
        return $this->render(':profile:success.htm.twig');
    }

    /**
     * @Route("/profile/mpesa/failed",name="mpesa_failed")
     */
    public function payFailedAction(Request $request)
    {

    }

    /**
     * @Route("/profile/mpesa/verify",name="verify-payment")
     */
    public function completePaymentAction(Request $request)
    {

        $profile = $this->container->get('session')->get('profile');
        $type = $this->container->get('session')->get('type');
        $em = $this->getDoctrine()->getManager();
        if ($type=="corporate") {
            $user = $em->getRepository("AppBundle:CorporateProfile")->findOneBy(['id' => $profile]);
            $sole =$user->getCompanyType();
        }else{
            $user = $em->getRepository("AppBundle:Profile")->findOneBy(['id' => $profile]);
            $sole="Individual";
        }
        if ($user->getMpesaStatus()=="Success"){
            $success="Success";
        $transactionArray = array("a" => $user->getMpesaConfirmationCode(), "b" => $user->getMpesaPaymentDate(), "c" => $user->getMpesaNumber(), "d" => $user->getMpesaAmount());
                
            if ($type=="corporate") {
                
                $this->sendVerificationEmail($user->getCompanyName(),$user->getEmailAddress(),$transactionArray);
                if ($user->getCompanyType()=="Sole Proprietorship"){
                    $corporateType=false;
                }else{
                    $corporateType=true;
                }
                $this->sendCorporateDocumentsEmail($user->getCompanyName(),$user->getEmailAddress(),$user->getId(),$corporateType);
            }else{
                $this->sendVerificationEmail($user->getApplicantName(),$user->getEmailAddress(),$transactionArray);
                $this->sendDocumentsEmail($user->getApplicantName(),$user->getEmailAddress(),$user->getId());
            }
        }else{
            $success="Failed";
        }

        return $this->render(':profile:verification.htm.twig', [
            'profile' => $user,
            'success' => $success,
            'type'=>$type,
            'sole'=>$sole
        ]);
    }
    /**
     * @Route("/profile/verify/{id}/later",name="verify-payment-later")
     */
    public function verifyPaymentAction(Request $request,Profile $profile)
    {
        $mpesa = new Mpesax($this->container);

        $em = $this->getDoctrine()->getManager();
        $transactionId = $profile->getMpesaVerificationCode();
        $response = $mpesa->usingTransactionId($transactionId)->requestStatus();
        //var_dump($response);exit;
        $mpesaStatus = new MpesaStatus($response);
        $customerNumber = $mpesaStatus->getCustomerNumber();
        $transactionAmount = $mpesaStatus->getTransactionAmount();
        $transactionStatus = $mpesaStatus->getTransactionStatus();
        $transactionDate = $mpesaStatus->getTransactionDate();
        $mPesaTransactionId = $mpesaStatus->getMpesaTransactionId();
        $merchantTransactionId = $mpesaStatus->getMerchantTransactionId();
        $transactionDescription = $mpesaStatus->getTransactionDescription();
        if ($transactionStatus == "Success") {
            $success = "Success";
            $profile->setMpesaConfirmationCode($mPesaTransactionId);
            $profile->setMpesaDescription($transactionDescription);
            $profile->setMpesaPaymentDate(new \DateTime($transactionDate));
            $profile->setMpesaStatus($transactionStatus);
            $profile->setMpesaVerificationCode($transactionId);
            $profile->setIsPaid(true);
            $profile->setMpesaNumber($customerNumber);
            $profile->setMpesaAmount($transactionAmount);
            $em->persist($profile);
            $em->flush();
            $transactionArray = array("a" => $mPesaTransactionId, "b" => $transactionDate, "c" => $customerNumber, "d" => $transactionAmount);
            /* $transactionCode ='<b>Mpesa Confirmation Code:<b>'..'<br/>
             <b>Mpesa Payment Date:<b>'..'<br/>
             <b>Mpesa Number:</b>'..'<br/>
             <b>Amount:</b>'.;*/
            $this->sendPaymentEmail($profile->getFirstName(), $profile->getEmailAddress(), $transactionArray);

        } else {
            $success = "Failed";
            $profile->setMpesaVerificationCode($transactionId);
            $em->persist($profile);
            $em->flush();
        }
        return $this->render(':profile:verificationLater.htm.twig', [
            'profile' => $profile,
            'success' => $success,
            'transactionId'=>$transactionId
        ]);
    }
    /**
     * @Route("/profile/mpesa/{id}/later",name="verify-later")
     */
    public function verifyLater(Request $request, Profile $profile){

        $em = $this->getDoctrine()->getManager();
        $transactionArray = array("a" => $profile->getId(), "b" => $profile->getMpesaVerificationCode());

        $this->sendVerificationEmail($profile->getFirstName(), $profile->getEmailAddress(), $transactionArray);

        return $this->render(':profile:verifyLater.htm.twig',[
            'profile' => $profile
        ]);
    }

    /**
     * @Route("/profile/{id}/edit")
     */
    public function editProfileAction(Request $request, Profile $profile)
    {
        $form = $this->createForm(ProfileForm::class, $profile);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $profile = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $em->flush();
            return $this->redirectToRoute('profile_updated', array('profileId' => $profile->getId()));
        } else {
            $errors = $form->getErrors();
        }
        return $this->render(':profile:new.htm.twig', ['profileForm' => $form->createView(), 'profile' => $profile, 'errors' => $errors]);
    }

    /**
     * @Route("/profile/{id}/pay",name="member-pay")
     */
    public function makePaymentAction(Request $request, Profile $userProfile)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(MpesaFormType::class, $userProfile);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->container->get('session')->set('profile', $userProfile);
            $amount = 10;
            $phoneNumber = $form["phoneNumber"]->getData();
            $referenceId = $userProfile->getIdNumber();
            $mpesa = new Mpesax($this->container);
            $transactionId = $mpesa->generateTransactionNumber();
            $response = $mpesa->request($amount)->from($phoneNumber)->usingReferenceId($referenceId)->usingTransactionId($transactionId)->transact();
            $statusCode = $response->getStatusCode();
            $this->container->get('session')->set('transactionId', $transactionId);
            if ($statusCode == 200) {
                return $this->redirectToRoute('mpesa_paid');
            } else {
                return $this->redirectToRoute('mpesa_failed');
            }

        }
        return $this->render('profile/pay.htm.twig', ['profile' => $userProfile, 'mpesaForm' => $form->createView()]);
    }
    public function sendVerificationEmail($firstName, $emailAddress, $code)
    {
        $message = \Swift_Message::newInstance()->setSubject('KAMP Online Portal Profile')->setFrom('kamp@patchcreate.com', 'KAMP Online Portal Team')->setTo($emailAddress)->setBody($this->renderView(// app/Resources/views/Emails/onboard.htm.twig
            'Emails/paid.htm.twig', array('name' => $firstName, 'code' => $code)), 'text/html');
        $this->get('mailer')->send($message);
    }
    public function sendDocumentsEmail($firstName, $emailAddress, $code)
    {
        $message = \Swift_Message::newInstance()->setSubject('KAMP Online Portal Profile')->setFrom('kamp@patchcreate.com', 'KAMP Online Portal Team')->setTo($emailAddress)->setBody($this->renderView(// app/Resources/views/Emails/onboard.htm.twig
            'Emails/documents.htm.twig', array('name' => $firstName, 'code' => $code)), 'text/html');
        $this->get('mailer')->send($message);
    }
    public function sendCorporateDocumentsEmail($firstName, $emailAddress, $code,$corporate)
    {
        $message = \Swift_Message::newInstance()->setSubject('KAMP Online Portal Profile')->setFrom('kamp@patchcreate.com', 'KAMP Online Portal Team')->setTo($emailAddress)->setBody($this->renderView(// app/Resources/views/Emails/onboard.htm.twig
            'Emails/corporateDocuments.htm.twig', array('name' => $firstName, 'code' => $code,'corporate'=>$corporate)), 'text/html');
        $this->get('mailer')->send($message);
    }
    public function sendPaymentEmail($firstName, $emailAddress, $code)
    {
        $message = \Swift_Message::newInstance()->setSubject('KAMP Online Portal Profile')->setFrom('kamp@patchcreate.com', 'KAMP Online Portal Team')->setTo($emailAddress)->setBody($this->renderView(// app/Resources/views/Emails/onboard.htm.twig
                'Emails/paid.htm.twig', array('name' => $firstName, 'code' => $code)), 'text/html');
        $this->get('mailer')->send($message);
    }

    public function sendWelcomeEmail($firstName, $emailAddress, $code)
    {
        $message = \Swift_Message::newInstance()->setSubject('KAMP Online Portal Profile')->setFrom('kamp@patchcreate.com', 'KAMP Online Portal Team')->setTo($emailAddress)->setBody($this->renderView(// app/Resources/views/Emails/onboard.htm.twig
                'Emails/profile.htm.twig', array('name' => $firstName)), 'text/html');
        $this->get('mailer')->send($message);

    }

    public function sendUnpaidWelcomeEmail($firstName, $emailAddress, $code)
    {
        $message = \Swift_Message::newInstance()->setSubject('KAMP Online Portal Profile')->setFrom('kamp@patchcreate.com', 'KAMP Online Portal Team')->setTo($emailAddress)->setBody($this->renderView(// app/Resources/views/Emails/onboard.htm.twig
                'Emails/unpaid.htm.twig', array('name' => $firstName, 'code' => $code)), 'text/html');
        $this->get('mailer')->send($message);
    }

    /**
     * @Route("/mpesa/updated/{transactionId}",name="mpesa_updated")
     */
    public function mpesaPaymentSuccessAction(Request $request,$transactionId)
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
        }else{

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
        return $this->render('profile/mpesa.htm.twig');
    }

    /**
     * @Route("/member/mpesa/fail", name="mpesa-success")
     */
    public function mpesaPaymentFailureAction()
    {
        $customerNumber = $_POST['MSISDN'];
        $amount = $_POST['AMOUNT'];
        $mpesaStatus = $_POST['TRX_STATUS'];
        $trasactionDate = $_POST['M­PESA_TRX_DATE'];
        $mPesaTrasactionId = $_POST['M­PESA_TRX_ID'];
        $transactionReferenceId = $_POST['MERCHANT_TRANSACTION_ID'];
        $mpesaDescritpion = $_POST['DESCRIPTION'];
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AppBundle:Profile")->findOneBy(['idNumber' => $transactionReferenceId]);
        $user->setMpesaConfirmationCode($mPesaTrasactionId);
        $user->setMpesaDescription($mpesaDescritpion);
        $user->setMpesaPaymentDate($trasactionDate);
        $user->setMpesaStatus($mpesaStatus);
        $user->setIsPaid(false);
        $em->persist($user);
        $em->flush();
    }

    /**
     * @Route("/documents/{id}/add",name="add-document")
     */
    public function addDocumentsAction(Request $request, Profile $profile)
    {
        $profileDocs = $profile->getProfileDocuments();
        $docName[] = array();
        $docChoices[]=array();

        if ($profileDocs) {
            //Get all the docs and put their type in an array
            foreach ($profileDocs as $profileDoc) {
                $docName[] = $profileDoc->getDocumentName();
            }
            //Create Choices based on Missing documents
            if (!in_array('PASSPORT-PHOTO', $docName)) {
                $docChoices['Colour Passport-Size Photo'] = 'PASSPORT-PHOTO';
            }
            if (!in_array('ID-COPY', $docName)) {
                $docChoices['Copy of Valid National ID/Passport/Birth Certificate'] = 'ID-COPY';
            }
            if (!in_array('KRA-PIN', $docName)) {
                $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';
            }
            if (!in_array('NEXT-OF-KIN-ID', $docName)) {
                $docChoices['Copy of Valid National ID/Passport or Birth Certificate Next of Kin'] = 'NEXT-OF-KIN-ID';
            }
        }else {
                $docChoices['Colour Passport-Size Photo'] = 'PASSPORT-PHOTO';
                $docChoices['Copy of Valid National ID/Passport/Birth Certificate'] = 'ID-COPY';
                $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';
                $docChoices['Copy of Valid National ID/Passport or Birth Certificate Next of Kin'] = 'NEXT-OF-KIN-ID';

        }
        $em = $this->getDoctrine()->getManager();

        $document = new Documents();
        $document->setWhichProfile($profile);

        $form = $this->createForm(DocumentsFormType::class, $document,['docChoices'=>$docChoices]);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $document = $form->getData();

            $profileId= $request->request->get('_pxc');

            $profile = $em->getRepository("AppBundle:Profile")
                ->findOneBy([
                    'id'=>$profileId
                ]);

            $em->persist($document);
            $em->flush();

            return $this->redirectToRoute("add-document",array('id' => $profile->getId(),'done'=>'success'));


        }
        return $this->render(':profile/documents:add.htm.twig',
            [
                'form' => $form->createView(),
                'profile' => $profile,
                'success' =>''
            ]
        );

    }
    /**
     * @Route("/corporate/{id}/add-documents",name="add-corporate-document")
     */
    public function addCorporateDocumentsAction(Request $request, CorporateProfile $profile)
    {
        $profileDocs = $profile->getCorporateProfileDocuments();
        $docName[] = array();
        $docChoices[]=array();

        if ($profileDocs) {
            //Get all the docs and put their type in an array
            foreach ($profileDocs as $profileDoc) {
                $docName[] = $profileDoc->getDocumentName();
            }
            //Create Choices based on Missing documents

            if (!in_array('REG-CERT', $docName)) {
                $docChoices['Copy of Certificate of Registration or Incorporation'] = 'REG-CERT';
            }
            if (!in_array('DIR1-PASSPORT-PHOTO', $docName)) {
                $docChoices['Colour Passport-Size Photo Of Director 1'] = 'DIR1-PASSPORT-PHOTO';
            }
            if (!in_array('DIR1-ID-COPY', $docName)) {
                $docChoices['Copy of Valid National ID/Passport/Birth Certificate Of Director 1'] = 'DIR1-ID-COPY';
            }
            if ($profile->getCompanyType()!="Sole Proprietorship"){
                if (!in_array('DIR2-PASSPORT-PHOTO', $docName)) {
                    $docChoices['Colour Passport-Size Photo Of Director 2'] = 'DIR2-PASSPORT-PHOTO';
                }
                if (!in_array('DIR2-ID-COPY', $docName)) {
                    $docChoices['Copy of Valid National ID/Passport/Birth Certificate Of Director 2'] = 'DIR2-ID-COPY';
                }
                if (!in_array('KRA-PIN', $docName)) {
                    $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';
                }
            }else{
                if (!in_array('NEXT-OF-KIN-ID', $docName)) {
                    $docChoices['Copy of Valid Next of Kin National ID/Passport/Birth Certificate'] = 'NEXT-OF-KIN-ID';
                }
                if (!in_array('KRA-PIN', $docName)) {
                    $docChoices['Copy of your Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';
                }
            }

        }else {
                 if ($profile->getCompanyType()!="Sole Proprietorship"){
                     $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';
                     $docChoices['Copy of Certificate of Registration or Incorporation'] = 'REG-CERT';
                     $docChoices['Colour Passport-Size Photo Of Director 1'] = 'DIR1-PASSPORT-PHOTO';
                     $docChoices['Copy of Valid National ID/Passport/Birth Certificate Of Director 1'] = 'DIR1-ID-COPY';

                    $docChoices['Colour Passport-Size Photo Of Director 2'] = 'DIR2-PASSPORT-PHOTO';
                    $docChoices['Copy of Valid National ID/Passport/Birth Certificate Of Director 2'] = 'DIR2-ID-COPY';
                    $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';

                }else{
                     $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';
                     $docChoices['Copy of Certificate of Business Name Registration'] = 'REG-CERT';
                     $docChoices['Colour Passport-Size Photo'] = 'DIR1-PASSPORT-PHOTO';
                     $docChoices['Copy of your Valid National ID/Passport/Birth Certificate Of Director 1'] = 'DIR1-ID-COPY';
                     $docChoices['Copy of Valid Next of Kin National ID/Passport/Birth Certificate'] = 'NEXT-OF-KIN-ID';
                     $docChoices['Copy of your Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';

                 }

        }
        $em = $this->getDoctrine()->getManager();

        $document = new Documents();
        $document->setWhichCorporateProfile($profile);

        $form = $this->createForm(DocumentsFormType::class, $document,['docChoices'=>$docChoices]);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $document = $form->getData();

            $profileId= $request->request->get('_pxc');

            $profile = $em->getRepository("AppBundle:CorporateProfile")
                ->findOneBy([
                    'id'=>$profileId
                ]);

            $em->persist($document);
            $em->flush();

            return $this->redirectToRoute("add-corporate-document",array('id' => $profile->getId(),'done'=>'success'));


        }
        return $this->render(':profile/documents:add-corporate.htm.twig',
            [
                'form' => $form->createView(),
                'profile' => $profile,
                'success' =>''
            ]
        );

    }


    /**
     * @Route("documents/added",name="document-added")
     */
    public function documentAddedAction(Request $request)
    {
        return $this->render(':profile/documents:added.htm.twig');
    }

    /**
     * @Route("/sample/{id}/add",name="add-sample")
     */
    public function addSampleAction(Request $request, Profile $profile)
    {

        $em = $this->getDoctrine()->getManager();

        $music = new Music();
        $music->setWhichProfile($profile);

        $form = $this->createForm(NewRecordingForm::class, $music);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $document = $form->getData();

            $profileId= $request->request->get('_pxc');

            $profile = $em->getRepository("AppBundle:Profile")
                ->findOneBy([
                    'id'=>$profileId
                ]);

            $em->persist($document);
            $em->flush();

            return $this->redirectToRoute("add-sample",array('id' => $profile->getId(),'done'=>'success'));


        }
        return $this->render(':profile/music:add-music.htm.twig',
            [
                'form' => $form->createView(),
                'profile' => $profile,
                'success' =>''
            ]
        );

    }
    /**
     * @Route("/corporate/{id}/add-samples",name="add-corporate-sample")
     */
    public function addCorporateSampleAction(Request $request, CorporateProfile $profile)
    {

        $em = $this->getDoctrine()->getManager();

        $music = new Music();
        $music->setWhichCorporateProfile($profile);

        $form = $this->createForm(NewRecordingForm::class, $music);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $document = $form->getData();

            $profileId= $request->request->get('_pxc');

            $profile = $em->getRepository("AppBundle:CorporateProfile")
                ->findOneBy([
                    'id'=>$profileId
                ]);

            $em->persist($document);
            $em->flush();

            return $this->redirectToRoute("add-corporate-sample",array('id' => $profile->getId(),'done'=>'success'));


        }
        return $this->render(':profile/music:add-corporate-music.htm.twig',
            [
                'form' => $form->createView(),
                'profile' => $profile,
                'success' =>''
            ]
        );
    }

    /**
     * @Route("samples/added",name="sample-added")
     */
    public function sampleAddedAction(Request $request)
    {
        return $this->render(':profile/documents:added.htm.twig');
    }



    public function documentExists($documentName, Profile $profile)
    {
        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository("AppBundle:Documents")->findOneBy(['documentName' => $documentName, 'whichProfile' => $profile]);
        if ($document) {
            return true;
        } else {
            return false;
        }
    }
}
