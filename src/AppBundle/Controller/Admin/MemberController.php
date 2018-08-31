<?php

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\CorporateProfile;
use AppBundle\Entity\NextOfKin;
use AppBundle\Entity\Profile;
use AppBundle\Entity\User;
use AppBundle\Form\CorporateReviewForm;
use AppBundle\Form\NewAdministratorForm;
use AppBundle\Form\ProfileReviewForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober;

/**
 * @Route("/admin")
 * @Security("is_granted('ROLE_ADMIN')")
 *
 */

class MemberController extends Controller
{
    /**
     * @Route("/",name="admin-dashboard")
     */
    public function dashboardAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Basic Profiles
        $nrCorporate = $em->getRepository("AppBundle:Onboard")
            ->findNrOnboards();
        $nrIndividual = $em->getRepository("AppBundle:Individual")
            ->findNrOnboards();

        //Pending Profiles
        $nrPendingIndividual = $em->getRepository("AppBundle:Profile")
            ->findNrUnderReview();
        $nrPendingCorporate = $em->getRepository("AppBundle:CorporateProfile")
            ->findNrUnderReview();

        //Membership Approved
        $nrMembershipApproved = $em->getRepository("AppBundle:Profile")
            ->findNrApproved();
        $nrMembershipApprovedCorporates = $em->getRepository("AppBundle:CorporateProfile")
            ->findNrApproved();

        //Board Approved
        $nrBoardApproved = $em->getRepository("AppBundle:Profile")
            ->findNrBoardApprovedProfiles();
        $nrBoardApprovedCorporates = $em->getRepository("AppBundle:CorporateProfile")
            ->findNrBoardApprovedProfiles();

        return $this->render('admin/dashboard.htm.twig',[
            'nrCorporate'=> $nrCorporate,
            'nrIndividual'=>$nrIndividual,
            'nrPendingIndividual'=> $nrPendingIndividual,
            'nrPendingCorporate' => $nrPendingCorporate,
            'nrMembershipApproved' => $nrMembershipApproved,
            'nrMembershipApprovedCorporates'=> $nrMembershipApprovedCorporates,
            'nrBoardApproved'=>$nrBoardApproved,
            'nrBoardApprovedCorporates' => $nrBoardApprovedCorporates
        ]);
    }

    /**
     * @Route("/onboard/corporate/step1",name="new-users")
     */
    public function onBoardAction(){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("AppBundle:Onboard")
            ->findBy([

            ],
                [
                    'createdAt'=>'Asc'
                ]);

        return $this->render('admin/step-1-users.htm.twig',[
            'users' => $users
        ]);
    }
    /**
     * @Route("/onboard/individual/step1",name="new-individual-users")
     */
    public function onBoardIndividualAction(){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("AppBundle:Individual")
            ->findBy([

            ],
                [
                    'createdAt'=>'Asc'
                ]);

        return $this->render('admin/step-1-individual.htm.twig',[
            'users' => $users
        ]);
    }

    /**
     * @Route("/profile/individual",name="open-profiles")
     */
    public function profileAction(){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("AppBundle:Profile")
            ->findBy([
                'profileStatus'=>'Pending'
            ],
                [
                    'createdAt'=>'Desc'
                ]);

        return $this->render('admin/open-profiles.htm.twig',[
            'users'=>$users
        ]);
    }
    /**
     * @Route("/profile/corporate",name="open-corporate-profiles")
     */
    public function corporateProfileAction(){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("AppBundle:CorporateProfile")
            ->findBy([
                'profileStatus'=>'Pending'
            ],
                [
                    'createdAt'=>'Desc'
                ]);

        return $this->render('admin/open-corporate-profiles.htm.twig',[
            'users'=>$users
        ]);
    }

    /**
     * @Route("/approved/profiles/individual",name="membership-approved-profiles")
     */
    public function membershipApprovedProfileAction(){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("AppBundle:Profile")
            ->findAllMembershipApprovedProfilesOrderByDate();

        return $this->render('admin/step-2-individual.htm.twig',[
            'users'=>$users
        ]);
    }
    /**
     * @Route("/approved/membership/corporates",name="membership-approved-corporates")
     */
    public function membershipApprovedCorporatesAction(){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("AppBundle:CorporateProfile")
            ->findAllMembershipApprovedProfilesOrderByDate();

        return $this->render('admin/step-2-corporate.htm.twig',[
            'users'=>$users
        ]);
    }

    /**
     * @Route("/approved/board/individual",name="board-approved-users")
     */
    public function approvedProfileAction(){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("AppBundle:Profile")
            ->findAllBoardApprovedProfilesOrderByDate();

        return $this->render('admin/boardApproved-users.htm.twig',[
            'users'=>$users
        ]);
    }
    /**
     * @Route("/approved/board/corporates",name="board-approved-corporates")
     */
    public function approvedCorporateAction(){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("AppBundle:Profile")
            ->findAllBoardApprovedProfilesOrderByDate();

        return $this->render('admin/boardApproved-corporates.htm.twig',[
            'users'=>$users
        ]);
    }

    /**
     * @Route("/members",name="members")
     */
    public function membersAction(){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("AppBundle:Profile")
            ->findAllApprovedProfilesOrderByDate();

        return $this->render('admin/approved-users.htm.twig',[
            'users'=>$users
        ]);
    }
    /**
     * @Route("/profiles/pending",name="pending-accounts")
     */
    public function pendingProfileAction(){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("AppBundle:User")
            ->findAllPendingUsers();

        return $this->render('admin/pending-accounts.htm.twig',[
            'users'=>$users
        ]);
    }

    /**
     * @Route("/profiles/rejected",name="rejected-users")
     */
    public function rejectedProfileAction(){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("AppBundle:Profile")
            ->findAllRejectedProfilesOrderByDate();

        return $this->render('admin/rejected-users.htm.twig',[
            'users'=>$users
        ]);
    }

    /**
     * @Route("/users/profile/{id}/review",name="review-profile")
     */
    public function reviewProfileAction(Request $request, Profile $profile){

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ProfileReviewForm::class);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){
            $comment = $request->request->get('comment');
            $approval = $request->request->get('approval');
           // var_dump($approval);exit;
            if ($approval =="Approved"){
                $profile->setProfileStatus("Approved");
                $profile->setIsMembershipApproved(true);
                $profile->setMembershipApprovedAt(new \DateTime());
                $profile->setMembershipApprovedBy($user);

                $twigTemplate = "membershipApproved.htm.twig";
                $accountStatus = "Prisk Portal Profile Approved";
            }else{
                $profile->setProfileStatus("Rejected");
                $profile->setIsMembershipApproved(false);
                $profile->setMembershipApprovedBy($user);
                $profile->setMembershipApprovedAt(new \DateTime());

                $twigTemplate = "rejected.htm.twig";
                $accountStatus = "Prisk Portal Profile Status";
            }
            $profile->setStatusDescription($comment);
            $profile->setProcessedBy($user);
            $profile->setProcessedAt(new \DateTime());

            $em->persist($profile);
            $em->flush();

         //   $this->sendEmail($profile->getFirstName(),$accountStatus,$profile->getEmailAddress(),$twigTemplate,null);

       //     return $this->redirectToRoute('open-profiles');
        }
        return $this->render('admin/profile/review.htm.twig',[
            'profile'=>$profile,
            'profileReviewForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/corporate/profile/{id}/review",name="review-corporate-profile")
     */
    public function reviewCorporateProfileAction(Request $request, CorporateProfile $profile){

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(CorporateReviewForm::class);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){
            $comment = $request->request->get('comment');
            $approval = $request->request->get('approval');

            if ($approval =="Approved"){
                $profile->setProfileStatus("Approved");
                $profile->setIsMembershipApproved(true);
                $profile->setMembershipApprovedAt(new \DateTime());
                $profile->setMembershipApprovedBy($user);

                $twigTemplate = "membershipApproved.htm.twig";
                $accountStatus = "Kamp Portal Profile Approved";
            }else{
                $profile->setProfileStatus("Rejected");
                $profile->setIsMembershipApproved(false);
                $profile->setMembershipApprovedBy($user);
                $profile->setMembershipApprovedAt(new \DateTime());

                $twigTemplate = "rejected.htm.twig";
                $accountStatus = "Kamp Portal Profile Status";
            }

            $profile->setStatusDescription($comment);
            $profile->setProcessedBy($user);
            $profile->setProcessedAt(new \DateTime());

            $em->persist($profile);
            $em->flush();

            $this->sendEmail($profile->getFirstDirectorNames(),$accountStatus,$profile->getEmailAddress(),$twigTemplate,null);

            return $this->redirectToRoute('open-corporate-profiles');
        }
        return $this->render('admin/profile/corporate-review.htm.twig',[
            'profile'=>$profile,
            'profileReviewForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/users/profile/{id}/pdf",name="pdf-profile")
     */
    public function pdfProfileAction(Request $request, Profile $profile){

        $user = $this->get('security.token_storage')->getToken()->getUser();


        $html = $this->renderView('admin/profile/profilePDF.htm.twig',[
            'profile'=>$profile,

        ]);

        $this->returnPDFResponseFromHTML($html);
    }
    public function returnPDFResponseFromHTML($html){
        //set_time_limit(30); uncomment this line according to your needs

        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetTitle(('Profile Review'));
        $pdf->SetSubject('Profile Review');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 11, '', true);
        $pdf->SetMargins(20,20,40, true);
        $pdf->AddPage();

        $filename = 'profile';

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
    }
    /**
     * @Route("/account/{id}/new",name="create-account")
     */
    public function createAccountAction(Request $request,Profile $profile){
        $admin = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $accountToken = base64_encode($profile->getIdNumber());

        $user = new User();
        $user->setIsActive(true);
        $user->setEmail($profile->getEmailAddress());
        $user->setFirstName($profile->getFirstName());
        $user->setLastName($profile->getLastName());
        $user->setIsPasswordCreated(false);
        $user->setMyProfile($profile);
        $user->setRoles(["ROLE_USER"]);
        $user->setPlainPassword($profile->getIdNumber());
        $user->setProfileLinkedAt(new \DateTime());
        $user->setAccountCreatedBy($admin);
        $user->setPasswordResetToken($accountToken);

        $profile->setAccountCreated("Created");

        $em->persist($profile);
        $em->persist($user);

        $em->flush();

        $this->sendEmail($profile->getFirstName(),"Your Prisk Portal Account",$profile->getEmailAddress(),"accountCreated.htm.twig",$profile->getId());

        return new Response(null, 204);
    }

    /**
     * @Route("/user/account/{id}/reset",name="request-password-reset")
     */
    public function requestPasswordResetAction(Request $request, User $user){

        $em = $this->getDoctrine()->getManager();

        //$resetToken = base64_encode(random_bytes(10));
        $resetToken = $user->getId();

        $user->setPlainPassword($resetToken."12");
        $user->setPasswordResetToken($resetToken);
        $user->setIsResetTokenValid(true);

        $em->persist($user);
        $em->flush();

        $this->sendEmail($user->getFirstName(),"Password Reset",$user->getEmail(),"passwordReset.htm.twig",$resetToken);

        return new Response(null,204);
    }
    /**
     * @Route("/user/account/{id}/deactivate",name="deactivate-account")
     */
    public function deactivateAccountAction(Request $request, User $user){

        $em = $this->getDoctrine()->getManager();

        $resetToken = base64_encode(random_bytes(10));

        $user->setPlainPassword($resetToken."12");
        $user->setIsActive(false);

        $em->persist($user);
        $em->flush();

        return new Response(null,204);
    }
    /**
     * @Route("/user/account/{id}/activate",name="activate-account")
     */
    public function activateAccountAction(Request $request, User $user){

        $em = $this->getDoctrine()->getManager();

        //$resetToken = base64_encode(random_bytes(10));
        $resetToken = $user->getId();

        $user->setPlainPassword($resetToken."12");
        $user->setPasswordResetToken($resetToken);
        $user->setIsResetTokenValid(true);
        $user->setIsActive(true);

        $em->persist($user);
        $em->flush();

        $this->sendEmail($user->getFirstName(),"Password Reset",$user->getEmail(),"passwordReset.htm.twig",$resetToken);

        return new Response(null,204);
    }


    protected function sendEmail($firstName,$subject,$emailAddress,$twigTemplate,$code){
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom('portal@kamp.or.ke','KAMP Online Portal Team')
            ->setTo($emailAddress)
            ->setBody(
                $this->renderView(
                    'Emails/'.$twigTemplate,
                    array(
                        'name' => $firstName,
                        'code' => $code
                    )
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);
    }
    /**
     * @Route("/next-of-kin/list/{id}",name="next-of-kin")
     */
    public function listKinAction(Request $request,Profile $profile){

        $em = $this->getDoctrine()->getManager();
        $user=$profile->getWhoseProfile();

        $nextOfKin = $em->getRepository('AppBundle:NextOfKin')
            ->findMyKin($user);

        return $this->render('admin/nextofkin/list.htm.twig', [
            'kinsList' => $nextOfKin,
            'user' =>$user
        ]);
    }
    /**
     * @Route("/next-of-kin/view/{id}",name="admin-view-kin-details")
     */
    public function viewNextOfKinAction(Request $request,NextOfKin $nextOfKin){
        $user = $nextOfKin->getWhoseKin();
        $profile = $user->getMyProfile();
        return $this->render('admin/nextofkin/details.htm.twig', [
            'nextOfKin' => $nextOfKin,
            'profile' =>$profile
        ]);

    }

    /**
     * @Route("/request/{id}/documents",name="request-documents")
     */
    public function requestDocumentsAction(Request $request,Profile $profile){
        $this->sendEmail($profile->getFirstName(),"Request for Documents",$profile->getEmailAddress(),'documents.htm.twig',$profile->getId());
        return new Response(null,200);
    }

    /**
     * @Route("/users/member-number/update",name="update-member-number")
     */
    public function updateMemberNumberAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $memberId = $request->request->get('pk');
        $memberNumber = $request->request->get('value');

        $member = $em->getRepository("AppBundle:Profile")
            ->findOneBy([
                'id'=>$memberId
            ]);

        if ($member){
            $member->setMemberNumber($memberNumber);
            $em->persist($member);
            $em->flush();
            return new Response(null,200);
        }else{
            return new Response(null,500);
        }


    }
    /**
     * @Route("/board/profile/{id}/review",name="board-review-profile")
     */
    public function boardProfileReviewAction(Request $request, Profile $profile){

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ProfileReviewForm::class);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){

            $comment = $request->request->get('comment');
            $approval = $request->request->get('approval');

            if ($approval =="Approved"){

                $nrApprovals = $profile->getNrBoardApprovals();

                if ($nrApprovals == 0 || $nrApprovals == ""){
                    $nrApprovals =1;
                    $profile->setNrBoardApprovals($nrApprovals);
                    $profile->setBoardApprover1($user);
                    $profile->setApproval1At(new \DateTime());
                    $profile->setBoardApprovalStatus1("Approved");
                }elseif ($nrApprovals == 1){
                    $nrApprovals =2;
                    $profile->setNrBoardApprovals($nrApprovals);
                    $profile->setBoardApprover2($user);
                    $profile->setApproval2At(new \DateTime());
                    $profile->setBoardApprovalStatus2("Approved");
                }elseif ($nrApprovals == 2){
                    $nrApprovals =3;
                    $profile->setNrBoardApprovals($nrApprovals);
                    $profile->setBoardApprover3($user);
                    $profile->setApproval3At(new \DateTime());
                    $profile->setBoardApprovalStatus3("Approved");
                    $profile->setIsBoardApproved(true);
                }

                $twigTemplate = "boardApproved.htm.twig";
                $accountStatus = "KAMP Membership Approved";
            }else{
                $profile->setIsBoardApproved(false);
                $profile->setIsBoardRejected(true);
                $profile->setBoardRejectionAt(new \DateTime());
                $profile->setBoardRejectionBy($user);
                $profile->setBoardRejectionReason($comment);

                $twigTemplate = "rejected.htm.twig";
                $accountStatus = "KAMP Portal Profile Status";
            }

            $profile->setStatusDescription($comment);
            $profile->setProcessedBy($user);
            $profile->setProcessedAt(new \DateTime());

            $em->persist($profile);
            $em->flush();

            //If All Board Members have approved, notify the user
            if ($profile->getNrBoardApprovals()==3) {
                $this->sendEmail($profile->getFirstName(), $accountStatus, $profile->getEmailAddress(), $twigTemplate, null);
            }
           // return $this->redirectToRoute('membership-approved-profiles');
        }
        return $this->render('admin/profile/boardReview.htm.twig',[
            'profile'=>$profile,
            'boardReviewForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/board/corporate/{id}/review",name="board-review-corporate")
     */
    public function boardCorporateReviewAction(Request $request, CorporateProfile $profile){

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(CorporateReviewForm::class);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){

            $comment = $request->request->get('comment');
            $approval = $request->request->get('approval');

            if ($approval =="Approved"){

                $nrApprovals = $profile->getNrBoardApprovals();

                if ($nrApprovals == 0 || $nrApprovals == ""){
                    $nrApprovals =1;
                    $profile->setNrBoardApprovals($nrApprovals);
                    $profile->setBoardApprover1($user);
                    $profile->setApproval1At(new \DateTime());
                    $profile->setBoardApprovalStatus1("Approved");
                }elseif ($nrApprovals == 1){
                    $nrApprovals =2;
                    $profile->setNrBoardApprovals($nrApprovals);
                    $profile->setBoardApprover2($user);
                    $profile->setApproval2At(new \DateTime());
                    $profile->setBoardApprovalStatus2("Approved");
                }elseif ($nrApprovals == 2){
                    $nrApprovals =3;
                    $profile->setNrBoardApprovals($nrApprovals);
                    $profile->setBoardApprover3($user);
                    $profile->setApproval3At(new \DateTime());
                    $profile->setBoardApprovalStatus3("Approved");
                    $profile->setIsBoardApproved(true);
                }

                $twigTemplate = "boardApproved.htm.twig";
                $accountStatus = "KAMP Membership Approved";
            }else{
                $profile->setIsBoardApproved(false);
                $profile->setIsBoardRejected(true);
                $profile->setBoardRejectionAt(new \DateTime());
                $profile->setBoardRejectionBy($user);
                $profile->setBoardRejectionReason($comment);

                $twigTemplate = "rejected.htm.twig";
                $accountStatus = "KAMP Portal Profile Status";
            }

            $profile->setStatusDescription($comment);
            $profile->setProcessedBy($user);
            $profile->setProcessedAt(new \DateTime());

            $em->persist($profile);
            $em->flush();

            //If All Board Members have approved, notify the user
            if ($profile->getNrBoardApprovals()==3) {
                $this->sendEmail($profile->getFirstName(), $accountStatus, $profile->getEmailAddress(), $twigTemplate, null);
            }
            // return $this->redirectToRoute('membership-approved-profiles');
        }
        return $this->render('admin/profile/corporateBoardReview.htm.twig',[
            'profile'=>$profile,
            'boardReviewForm' => $form->createView()
        ]);
    }

}
