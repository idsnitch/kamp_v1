<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Documents;
use AppBundle\Entity\Music;
use AppBundle\Entity\Profile;
use AppBundle\Form\ApplicantDetailsForm;
use AppBundle\Form\CorporateDetailsForm;
use AppBundle\Form\CorporatePaymentForm;
use AppBundle\Form\DocumentsFormType;
use AppBundle\Form\NewRecordingForm;
use AppBundle\Form\PaymentForm;
use AppBundle\Form\ProfileForm;
use AppBundle\Form\ProfileKinForm;
use AppBundle\Form\VerificationForm;
use Crysoft\MpesaBundle\Helpers\Mpesa;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/profile")
 * @Security("is_granted('ROLE_USER')")
 *
 */
class HomeController extends Controller
{
    /**
     * @Route("/update",name="update")
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user->getUserType()=="Individual" || $user->getUserType()=="Deceased Producer") {
            if ($user->getProfile()->getProgress() == "Initial") {
                return $this->redirectToRoute("initial");
            }if ($user->getProfile()->getProgress() == "NextOfKin") {
                return $this->redirectToRoute("next-of-kin");
            } elseif ($user->getProfile()->getProgress() == "Documents") {
                return $this->redirectToRoute("documents");
            } elseif ($user->getProfile()->getProgress() == "Recordings") {
                return $this->redirectToRoute("recording-sample");
            } elseif ($user->getProfile()->getProgress() == "Confirmation") {
                return $this->redirectToRoute("confirm-profile");
            }elseif ($user->getprofile()->getProgress() == "Payment") {
                return $this->redirectToRoute("payment");
            }
            return $this->render('home/home.htm.twig');
        }else{
            if ($user->getCorporateProfile()->getProgress()=="Initial"){
                return $this->redirectToRoute('initial-corporate');
            }elseif($user->getCorporateProfile()->getProgress()=="Documents"){
                return $this->redirectToRoute('corporate-documents');
            }elseif($user->getCorporateProfile()->getProgress()=="Recordings"){
                return $this->redirectToRoute('corporate-recording-sample');
            }elseif($user->getCorporateProfile()->getProgress()=="Payment"){
                return $this->redirectToRoute('payment');
            }
            return $this->render('home/corporateHome.htm.twig');
        }
    }
    /**
     * @Route("/update/individual/initial",name="initial")
     */
    public function initialProfileAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em= $this->getDoctrine()->getManager();

        $profile = $user->getProfile();

        $userProfile = $em->getRepository("AppBundle:Profile")
            ->findOneBy([
                'id'=>$profile->getId()
            ]);
        $form = $this->createForm(ApplicantDetailsForm::class,$userProfile);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $prof = $form->getData();
            if ($user->getUserType()=="Deceased Producer"){
             $prof->setProgress("Documents");
            }else {
                $prof->setProgress("NextOfKin");
            }
            $em->persist($prof);
            $em->flush();
            /*if ($user->getUserType()=="Deceased Producer"){
                return $this->redirectToRoute('documents');
            }else {
                return $this->redirectToRoute("next-of-kin");
            }*/
            return $this->redirectToRoute("next-of-kin");
        }

        return $this->render(':home:initial.htm.twig',[
            'profileForm'=>$form->createView(),
            'profile'=>$userProfile
        ]);
    }
    /**
     * @Route("/update/individual/kin",name="next-of-kin")
     */
    public function kinProfileAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getProfile();

        $form = $this->createForm(ProfileKinForm::class,$profile);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $profile = $form->getData();

            $em= $this->getDoctrine()->getManager();
            $profile->setProgress("Documents");
            $em->persist($profile);
            $em->flush();
            return $this->redirectToRoute('documents');
        }

        return $this->render(':home:nextOfKin.htm.twig',[
            'profileForm'=>$form->createView()
        ]);
    }
    /**
     * @Route("/update/individual/documents",name="documents")
     */
    public function documentsAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getProfile();

        $profileDocs = $profile->getProfileDocuments();
        $docName[] = array();
        $docChoices[]=array();

        if ($profileDocs) {
            //Get all the docs and put their type in an array
            foreach ($profileDocs as $profileDoc) {
                $docName[] = $profileDoc->getDocumentName();
            }
            if ($user->getUserType()=="Deceased Producer"){
                //Create Choices based on Missing documents
                if (!in_array('ADMINISTRATION-LETTER', $docName)) {
                    $docChoices['Letters of Administration'] = 'ADMINISTRATION-LETTER';
                }
                if (!in_array('DEATH-CERTIFICATE', $docName)) {
                    $docChoices['Death Certificate'] = 'DEATH-CERTIFICATE';
                }
            }
            //Create Choices based on Missing documents
            if (!in_array('PASSPORT-PHOTO', $docName)) {
                $docChoices['Colour Passport-Size Photo'] = 'PASSPORT-PHOTO';
            }
            if (!in_array('NATIONAL-ID-COPY', $docName)) {
                $docChoices['Copy of Valid National ID/Passport/Birth Certificate'] = 'NATIONAL-ID-COPY';
            }
            if (!in_array('KRA-PIN', $docName)) {
                $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-CERTIFICATE';
            }
            if (!in_array('NEXT-OF-KIN-CERTIFICATE', $docName)) {
                $docChoices['Copy of Valid National ID/Passport or Birth Certificate Next of Kin'] = 'NEXT-OF-KIN-CERTIFICATE';
            }
        }else {
            if ($user->getUserType="Deceased Producer"){
                $docChoices['Letters of Administration'] = 'ADMINISTRATION-LETTER';
                $docChoices['Death Certificate'] = 'DEATH-CERTIFICATE';

            }
            $docChoices['Colour Passport-Size Photo'] = 'PASSPORT-PHOTO';
            $docChoices['Copy of Valid National ID/Passport/Birth Certificate'] = 'NATIONAL-ID-COPY';
            $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-CERTIFICATE';
            $docChoices['Copy of Valid National ID/Passport or Birth Certificate Next of Kin'] = 'NEXT-OF-KIN-CERTIFICATE';

        }
        $em = $this->getDoctrine()->getManager();

        $document = new Documents();
        $document->setWhichProfile($profile);

        $form = $this->createForm(DocumentsFormType::class, $document,['docChoices'=>$docChoices]);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $document = $form->getData();

            $em->persist($document);
            $em->flush();

            return new Response(null,200);

        }elseif($form->isSubmitted()&&!$form->isValid()){
            return new Response(null,500);
        }
        return $this->render(':home:documents.htm.twig',[
            'form'=>$form->createView(),
            'profile'=>$profile
        ]);
    }
    /**
     * @Route("/upload/docs/form",name="upload-form")
     */
    public function docUploadFormAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getProfile();

        $profileDocs = $profile->getProfileDocuments();
        $docName[] = array();
        $docChoices[]=array();

        if ($profileDocs) {
            //Get all the docs and put their type in an array
            foreach ($profileDocs as $profileDoc) {
                $docName[] = $profileDoc->getDocumentName();
            }
            if ($user->getUserType()=="Deceased Producer"){
                //Create Choices based on Missing documents
                if (!in_array('ADMINISTRATION-LETTER', $docName)) {
                    $docChoices['Letters of Administration'] = 'ADMINISTRATION-LETTER';
                }
                if (!in_array('DEATH-CERTIFICATE', $docName)) {
                    $docChoices['Death Certificate'] = 'DEATH-CERTIFICATE';
                }
                //Create Choices based on Missing documents
                if (!in_array('PASSPORT-PHOTO', $docName)) {
                    $docChoices['Next of Kin Colour Passport-Size Photo'] = 'PASSPORT-PHOTO';
                }
                if (!in_array('NATIONAL-ID-COPY', $docName)) {
                    $docChoices['Copy of Valid Next of Kin National ID/Passport/Birth Certificate'] = 'NATIONAL-ID-COPY';
                }
                if (!in_array('KRA-CERTIFICATE', $docName)) {
                    $docChoices['Copy of Next of Kin Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-CERTIFICATE';
                }
            }else{
                //Create Choices based on Missing documents
                if (!in_array('PASSPORT-PHOTO', $docName)) {
                    $docChoices['Colour Passport-Size Photo'] = 'PASSPORT-PHOTO';
                }
                if (!in_array('NATIONAL-ID-COPY', $docName)) {
                    $docChoices['Copy of Valid National ID/Passport/Birth Certificate'] = 'NATIONAL-ID-COPY';
                }
                if (!in_array('KRA-CERTIFICATE', $docName)) {
                    $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-CERTIFICATE';
                }
                if (!in_array('NEXT-OF-KIN-CERTIFICATE', $docName)) {
                    $docChoices['Copy of Valid National ID/Passport or Birth Certificate Next of Kin'] = 'NEXT-OF-KIN-CERTIFICATE';
                }
            }

        }else {
            if ($user->getUserType="Deceased Producer"){
                $docChoices['Letters of Administration'] = 'ADMINISTRATION-LETTER';
                $docChoices['Death Certificate'] = 'DEATH-CERTIFICATE';

            }
            $docChoices['Colour Passport-Size Photo'] = 'PASSPORT-PHOTO';
            $docChoices['Copy of Valid National ID/Passport/Birth Certificate'] = 'NATIONAL-ID-COPY';
            $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-CERTIFICATE';
            $docChoices['Copy of Valid National ID/Passport or Birth Certificate Next of Kin'] = 'NEXT-OF-KIN-CERTIFICATE';

        }
        $em = $this->getDoctrine()->getManager();

        $document = new Documents();
        $document->setWhichProfile($profile);

        $form = $this->createForm(DocumentsFormType::class, $document,['docChoices'=>$docChoices]);

        return $this->render('home/docUploadForm.htm.twig',[
            'form'=>$form->createView(),
            'profile'=>$profile
        ]);
    }
    /**
     * @Route("/uploaded/docs",name="uploaded-documents")
     */
    public function uploadedDocumentsAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getProfile();

        return $this->render('home/docUpload.htm.twig',[
            'profile'=>$profile
        ]);
    }
    /**
     * @Route("/update/corporate/initial",name="initial-corporate")
     */
    public function initialCorporateProfileAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em= $this->getDoctrine()->getManager();

        $profile = $user->getCorporateProfile();

        $form = $this->createForm(CorporateDetailsForm::class,$profile);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $prof = $form->getData();

            $prof->setProgress("Documents");
            $prof->setCompanyType($profile->getCompanyType());

            $em->persist($prof);
            $em->flush();
            return $this->redirectToRoute("corporate-documents");

        }

        return $this->render(':home/corporate:initial.htm.twig',[
            'profileForm'=>$form->createView(),
            'profile'=>$profile
        ]);
    }
    /**
     * @Route("/update/corporate/documents",name="corporate-documents")
     */
    public function corporateDocumentsAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getCorporateProfile();

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
                if ($profile->getNumberOfDirectors()==2){
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
                    if (!in_array('KIN-ID', $docName)) {
                        $docChoices['Copy of Valid Next of Kin National ID/Passport/Birth Certificate'] = 'KIN-ID';
                    }
                    if (!in_array('KRA-PIN', $docName)) {
                        $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';
                    }
                }

            }else{
                if (!in_array('KIN-ID', $docName)) {
                    $docChoices['Copy of Valid Next of Kin National ID/Passport/Birth Certificate'] = 'KIN-ID';
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
                if($profile->getNumberOfDirectors()==2){
                    $docChoices['Colour Passport-Size Photo Of Director 2'] = 'DIR2-PASSPORT-PHOTO';
                    $docChoices['Copy of Valid National ID/Passport/Birth Certificate Of Director 2'] = 'DIR2-ID-COPY';

                }else{
                    $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';
                    $docChoices['Copy of Valid Next of Kin National ID/Passport/Birth Certificate'] = 'KIN-ID';

                }

            }else{
                $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';
                $docChoices['Copy of Certificate of Business Name Registration'] = 'REG-CERT';
                $docChoices['Colour Passport-Size Photo'] = 'DIR1-PASSPORT-PHOTO';
                $docChoices['Copy of your Valid National ID/Passport/Birth Certificate Of Director 1'] = 'DIR1-ID-COPY';
                $docChoices['Copy of Valid Next of Kin National ID/Passport/Birth Certificate'] = 'KIN-ID';
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

            $em->persist($document);
            $em->flush();

            return new Response(null,200);

        }elseif($form->isSubmitted()&&!$form->isValid()){
            return new Response(null,500);
        }
        return $this->render('home/corporate/documents.htm.twig',[
            'form'=>$form->createView(),
            'profile'=>$profile
        ]);
    }

    /**
     * @Route("/upload/corp/form",name="upload-corporate-form")
     */
    public function corpDocUploadFormAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();


        $profile = $user->getCorporateProfile();

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
            if ($profile->getCompanyType()!="Sole Proprietorship"&&$profile->getNumberOfDirectors()==2){
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
                if (!in_array('KIN-ID', $docName)) {
                    $docChoices['Copy of Valid Next of Kin National ID/Passport/Birth Certificate'] = 'KIN-ID';
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
                if ($profile->getNumberOfDirectors()==2) {
                    $docChoices['Colour Passport-Size Photo Of Director 2'] = 'DIR2-PASSPORT-PHOTO';
                    $docChoices['Copy of Valid National ID/Passport/Birth Certificate Of Director 2'] = 'DIR2-ID-COPY';
                }else {
                    $docChoices['Copy of Valid Next of Kin National ID/Passport/Birth Certificate'] = 'KIN-ID';

                    $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';
                }
            }else{
                $docChoices['Copy of Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';
                $docChoices['Copy of Certificate of Business Name Registration'] = 'REG-CERT';
                $docChoices['Colour Passport-Size Photo'] = 'DIR1-PASSPORT-PHOTO';
                $docChoices['Copy of your Valid National ID/Passport/Birth Certificate Of Director 1'] = 'DIR1-ID-COPY';
                $docChoices['Copy of Valid Next of Kin National ID/Passport/Birth Certificate'] = 'KIN-ID';
                $docChoices['Copy of your Kenya Revenue Authority ITAX Updated Pin Certificate'] = 'KRA-PIN';

            }

        }
        $em = $this->getDoctrine()->getManager();

        $document = new Documents();
        $document->setWhichCorporateProfile($profile);

        $form = $this->createForm(DocumentsFormType::class, $document,['docChoices'=>$docChoices]);

        $form = $this->createForm(DocumentsFormType::class, $document,['docChoices'=>$docChoices]);

        return $this->render('home/corporate/docUploadForm.htm.twig',[
            'form'=>$form->createView(),
            'profile'=>$profile
        ]);
    }
    /**
     * @Route("/uploaded/corp/docs",name="uploaded-corporate-documents")
     */
    public function corpUploadedDocumentsAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getCorporateProfile();

        return $this->render('home/corporate/docUpload.htm.twig',[
            'profile'=>$profile
        ]);
    }
    /**
     * @Route("/update/individual/recording",name="recording-sample")
     */
    public function recordingSamplesAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $profile = $user->getProfile();
        $profile->setProgress("Recording");

        $recording = new Music();
        $recording->setCreatedAt(new \DateTime());
        $recording->setUpdatedAt(new \DateTime());
        $recording->setWhichProfile($profile);

        $form = $this->createForm(NewRecordingForm::class,$recording);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $sample = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($sample);
            $em->flush();

            return $this->redirectToRoute('recording-sample');

        }elseif($form->isSubmitted()&&!$form->isValid()){
            return new Response(null,500);
        }

        return $this->render(':home/samples:musicSample.htm.twig',[
            'profile'=>$profile,
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/update/uploaded-recording",name="uploaded-individual-recording")
     */
    public function uploadedRecordingSamplesAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getProfile();

        return $this->render(':home/samples:sampleUpload.htm.twig',[
            'profile'=>$profile
        ]);
    }

    /**
     * @Route("/sample-upload-form",name="sample-upload-form")
     */
    public function sampleUploadFormAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getProfile();

        $recording = new Music();
        $recording->setCreatedAt(new \DateTime());
        $recording->setUpdatedAt(new \DateTime());
        $recording->setWhichProfile($profile);

        $form = $this->createForm(NewRecordingForm::class,$recording);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $sample = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($sample);
            $em->flush();

            return new Response(null,200);
        }elseif($form->isSubmitted()&&!$form->isValid()){
            return new Response(null,500);
        }
        return $this->render(':home/samples:sampleUploadForm.htm.twig',[
            'form'=>$form->createView(),
            'profile'=>$profile
        ]);
    }

    /**
     * @Route("/update/corporate/recording",name="corporate-recording-sample")
     */
    public function corporateRecordingSamplesAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $profile = $user->getCorporateProfile();
        $profile->setProgress("Recording");

        $recording = new Music();
        $recording->setCreatedAt(new \DateTime());
        $recording->setUpdatedAt(new \DateTime());
        $recording->setWhichCorporateProfile($profile);

        $form = $this->createForm(NewRecordingForm::class,$recording);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $sample = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($recording);
            $em->persist($sample);
            $em->flush();

            return $this->redirectToRoute('corporate-recording-sample');
        }elseif($form->isSubmitted()&&!$form->isValid()){
            return new Response(null,500);
        }

        return $this->render(':home/corporate/samples:musicSample.htm.twig',[
            'profile'=>$profile,
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/update/uploaded-corporate-recording",name="uploaded-corporate-recording")
     */
    public function uploadedCorporateRecordingSamplesAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getCorporateProfile();

        return $this->render(':home/corporate/samples:sampleUpload.htm.twig',[
            'profile'=>$profile
        ]);
    }

    /**
     * @Route("/sample-corporate-upload-form",name="sample-corporate-upload-form")
     */
    public function sampleCorporateUploadFormAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getCorporateProfile();

        $recording = new Music();
        $recording->setCreatedAt(new \DateTime());
        $recording->setUpdatedAt(new \DateTime());
        $recording->setWhichCorporateProfile($profile);

        $form = $this->createForm(NewRecordingForm::class,$recording);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $sample = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($sample);
            $em->flush();

            return new Response(null,200);
        }elseif($form->isSubmitted()&&!$form->isValid()){
            return new Response(null,500);
        }
        return $this->render(':home/corporate/samples:sampleUploadForm.htm.twig',[
            'form'=>$form->createView(),
            'profile'=>$profile
        ]);
    }

    /**
     * @Route("/update/individual/confirm",name="confirm-profile")
     */
    public function confirmProfileAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getProfile();
        $profile->setProgress("Confirmation");

        $form = $this->createForm(ProfileKinForm::class,$profile);

        return $this->render(':home:confirm.htm.twig',[
            'profileForm'=>$form->createView(),
            'profile'=>$profile
        ]);

    }
    /**
     * @Route("/update/corporate/confirm",name="corporate-confirm-profile")
     */
    public function corporateConfirmProfileAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getCorporateProfile();
        $profile->setProgress("Confirmation");

        //$form = $this->createForm(ProfileKinForm::class,$profile);

        return $this->render(':home/corporate:sole-confirm.htm.twig',[
          //  'profileForm'=>$form->createView(),
            'profile'=>$profile
        ]);

    }
    /**
     * @Route("/update/payment",name="payment")
     */
    public function paymentAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $profile = $user->getProfile();
        $profile->setProgress("Payment");

        $form = $this->createForm(PaymentForm::class,$profile);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $amount = 10;
            $phoneNumber = $form["mobileNumber"]->getData();
            $prof = $form->getData();

            $referenceId = time();

            $prof->setProfileStatus("Pending");
            $prof->setIdemnifyAt(new \DateTime());
            $prof->setReferenceId($referenceId);
            $em->persist($prof);
            $em->flush();

            //$referenceId = $userProfile->getIdNumber();
            $mpesa = new Mpesa($this->container);

            $transactionId = $mpesa->generateTransactionNumber();
            $this->container->get('session')->set('transactionId',$transactionId);

            $response = $mpesa->request($amount)->from($phoneNumber)->usingReferenceId($referenceId)->usingTransactionId($transactionId)->transact();

            return $this->redirectToRoute('payment-confirmed');
        }

        return $this->render('home/payment/payment.htm.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/payment/confirm",name="payment-confirmed")
     */
    public function paymentConfirmation(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getProfile();

        $form = $this->createForm(VerificationForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if ($profile->getMpesaStatus()=="Success"){
                return new Response(null,200);
            }else{
                return new Response(null,500);
            }
        }
        return $this->render('home/payment/paymentConfirmation.htm.twig',[
            'form'=>$form->createView(),
            'profile'=>$profile
        ]);
    }

    /**
     * @Route("/payment/form",name="payment-form")
     */
    public function paymentFormAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getProfile();
        $profile->setIdemnifyAt(new \DateTime());

        $form = $this->createForm(PaymentForm::class,$profile);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $amount = 10;
            $phoneNumber = $form["mobileNumber"]->getData();
            $referenceId = time();
            //$referenceId = $userProfile->getIdNumber();
            $mpesa = new Mpesa($this->container);

            $transactionId = $mpesa->generateTransactionNumber();
            $this->container->get('session')->set('transactionId',$transactionId);

            $response = $mpesa->request($amount)->from($phoneNumber)->usingReferenceId($referenceId)->usingTransactionId($transactionId)->transact();

        }

        return $this->render('home/payment/paymentForm.htm.twig',[
            'form'=>$form->createView(),

        ]);
    }
    /**
     * @Route("/payment/confirm/form",name="payment-confirmation-form")
     */
    public function paymentConfirmationFormAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getProfile();

        $form = $this->createForm(VerificationForm::class,$profile);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
          if ($profile->getMpesaStatus()=="Success"){
              //$transactionArray
              return new Response(null,200);
          }else{
              return new Response(null,500);
          }

        }

        return $this->render('home/payment/confirmPayment.htm.twig',[
            'form'=>$form->createView(),

        ]);
    }

    /**
     * @Route("/payment/details",name="payment-details")
     */
    public function paymentDetailsAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getProfile();

        return $this->render(':home/payment:paymentDetails.htm.twig',[
            'profile'=>$profile
        ]);
    }


    /**
     * @Route("/update/corporate/payment",name="corporatepayment")
     */
    public function corporatePaymentAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $profile = $user->getCorporateProfile();
        $profile->setProgress("Payment");

        $form = $this->createForm(CorporatePaymentForm::class,$profile);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $amount = 10;
            $phoneNumber = $form["mobileNumber"]->getData();
            $prof = $form->getData();
            $referenceId = time();
            $prof->setProfileStatus("Pending");
            $prof->setReferenceId($referenceId);
            $prof->setIdemnifyAt(new \DateTime());
            $em->persist($prof);
            $em->flush();

            $prof->setReferenceId($referenceId);
            //$referenceId = $userProfile->getIdNumber();
            $mpesa = new Mpesa($this->container);

            $transactionId = $mpesa->generateTransactionNumber();
            $this->container->get('session')->set('transactionId',$transactionId);


            $response = $mpesa->request($amount)->from($phoneNumber)->usingReferenceId($referenceId)->usingTransactionId($transactionId)->transact();



            return $this->redirectToRoute('corporate-payment-confirmed');
        }

        return $this->render('home/corporate/payment/payment.htm.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/payment/corporate/confirm",name="corporate-payment-confirmed")
     */
    public function corporatePaymentConfirmation(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getCorporateProfile();

        $form = $this->createForm(VerificationForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if ($profile->getMpesaStatus()=="Success"){
                return new Response(null,200);
            }else{
                return new Response(null,500);
            }
        }
        return $this->render('home/corporate/payment/paymentConfirmation.htm.twig',[
            'form'=>$form->createView(),
            'profile'=>$profile
        ]);
    }

    /**
     * @Route("/payment/corporate/form",name="corporate-payment-form")
     */
    public function corporatePaymentFormAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getCorporateProfile();
        $profile->setIdemnifyAt(new \DateTime());

        $form = $this->createForm(CorporatePaymentForm::class,$profile);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $amount = 10;
            $phoneNumber = $form["mobileNumber"]->getData();
            $referenceId = time();
            //$referenceId = $userProfile->getIdNumber();
            $mpesa = new Mpesa($this->container);

            $transactionId = $mpesa->generateTransactionNumber();
            $this->container->get('session')->set('transactionId',$transactionId);

            $response = $mpesa->request($amount)->from($phoneNumber)->usingReferenceId($referenceId)->usingTransactionId($transactionId)->transact();

        }

        return $this->render('home/corporate/payment/paymentForm.htm.twig',[
            'form'=>$form->createView(),

        ]);
    }
    /**
     * @Route("/payment/corporate/confirm/form",name="corporate-payment-confirmation-form")
     */
    public function corporatePaymentConfirmationFormAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getCorporateProfile();

        $form = $this->createForm(VerificationForm::class,$profile);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if ($profile->getMpesaStatus()=="Success"){
                return new Response(null,200);
            }else{
                return new Response(null,500);
            }

        }

        return $this->render('home/corporate/payment/confirmPayment.htm.twig',[
            'form'=>$form->createView(),

        ]);
    }

    /**
     * @Route("/payment/corporate/details",name="corporate-payment-details")
     */
    public function corporatePaymentDetailsAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $profile = $user->getCorporateProfile();

        return $this->render(':home/corporate/payment:paymentDetails.htm.twig',[
            'profile'=>$profile
        ]);
    }

}
