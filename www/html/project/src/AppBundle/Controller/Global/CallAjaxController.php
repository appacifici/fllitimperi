<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use AppBundle\Entity\ExternalUser;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Newsletter;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Service\EmailService\GetResponseManager;

class CallAjaxController extends TemplateController {

    /**
    * @Route("/amp/getFormLogin", name="getFormLoginAMP")
    */
    public function getFormLoginAction ( Request $request ) {
        $this->setParameters();
        echo $this->get('twig')->render( 'amp_template/getFormLogin.html.twig', array( 'sessionActive' => $this->sessionActive ) );
        exit;
    }
    
    /**
     * @Route("/call/ajax/widget")
     */
    public function widgetAction(Request $request) {                 
        return new Response($this->compressHtml($this->renderSingleTemplate($request)));

        if ($this->checkSetResponseCache($request)) { 
            $ttl = $this->getTTLCacheResponse($request->query->get('widget'));

            $eTag = md5($request->server->get('REQUEST_URI')) . '?v=' . $this->container->getParameter('app.eTagVersion');
//            $d = new \DateTime();
//            $date = $d->createFromFormat( 'Y-m-d', $request->query->get( 'date' ) );

            $response = new Response();
            $response->setETag($eTag);
            $response->setPublic();

            //se esiste la copia cachata la restituisce
            if ($response->isNotModified($request)) {
                $response->setNotModified();
                return $response;
            } else {
                //recupera la risposta e la setta in cache
                $response = new Response($this->renderSingleTemplate($request));
                $response->setETag($eTag);
                $response->setPublic();
                $response->setMaxAge($ttl);
                $response->setSharedMaxAge($ttl);
//                $response->headers->addCacheControlDirective('must-revalidate', true);

                return $response;
            }
        } else {
            return new Response($this->renderSingleTemplate($request));
        }
    }

    /**
     * @Route("/call/ajax/dataWidget")
     */
    public function dataWidgetAction(Request $request) {
        if ($this->checkSetResponseCache($request)) {
            $ttl = $this->getTTLCacheResponse($request->query->get('widget'));

            $cacheUtility = $this->container->get('app.cacheUtility');
            $cacheUtility->initPhpCache();
            
            $eTag = md5($request->server->get('REQUEST_URI')) . '?v=' . $this->container->getParameter('app.eTagVersion');

            $data = $cacheUtility->phpCacheGet($this->container->getParameter('session_memcached_prefix') . 'dataWidget_' . $eTag);
            if (empty($data)) {
                $data = json_encode($this->getDataCoreWidget($request));
                $cacheUtility->phpCacheSet($this->container->getParameter('session_memcached_prefix') . 'dataWidget_' . $eTag, $data, $ttl);
            }
            $cacheUtility->closePhpCache();
        } else {
            $data = json_encode($this->getDataCoreWidget($request));
        }        
        return new Response($data);
    }
    
    /**
     * @Route("/admin/getInfiniteScroller/page={page}")
     */
    public function dataInfiniteScrollImgAction(Request $request) {
        $secondLevelCacheUtility = $this->getSecondLevelCache();             
        $this->getDoctrine()->getRepository('AppBundle:Image')->setCacheUtility( $secondLevelCacheUtility );
        
        $core = $this->container->get('app.coreAdminImageArticle');
        $result = $core->getDataToAjax();
        
        return new Response($result);
    }
    
    /**
     * @Route("/news/getInfiniteScrollerListNews/page={page}")
     * @Route("/admin/getInfiniteScrollerListNews/page={page}")
     */
    public function dataInfiniteScrollListNewsAction(Request $request) {
        $this->setParameters();
        $core = $this->container->get('app.coreListNews');
        $result = $core->getDataToAjax();
                
        return new Response($result);
    }
    
    /**
     * @Route("/product/getInfiniteScrollerListNews/page={page}")
     */
    public function dataInfiniteScrollListProductsAction(Request $request) {
        $this->setParameters( 'listProduct' );
        $core = $this->container->get('app.coreListProducts');
        $result = $core->getDataToAjax();
                
        return new Response($result);
    }
    
    
    /**
     * @Route("/news/getInfiniteScrollerListPolls/page={page}")
     * @Route("/admin/getInfiniteScrollerListPolls/page={page}")
     */
    public function dataInfiniteScrollListPollsAction(Request $request) {
        $this->setParameters();
        $core = $this->container->get('app.coreListPolls');
        $result = $core->getDataToAjax();
                
        return new Response($result);
    }
    
    /**
     * @Route("/admin/getInfiniteScrollerGetty/page={page}/{searchString}", defaults={"searchString" = false})
     */
    public function dataInfiniteScrollGettyImgAction(Request $request) {
        $core = $this->container->get('app.coreAdminImageArticleGetty');
        $result = $core->getDataToAjax();
        
        return new Response($result);
    }
    
    /**
     * @Route("/openComparisonListModel")
     */
    public function openComparisonListModelAction(Request $request) {
        $core = $this->container->get('app.coreListModelsComparison');
        $result = $core->getDataToAjax();
        
        $this->setParameters();
        $html = $this->get('twig')->render( 'template/widget_BoxListModelComparison.html.twig', array( 'models' => $result ) );
        
        return new Response( $html );
    }
    
    /**   
     * @Route( "/admin/getModelProductsFromIde", name="getModelProductsFromIde" )     
     */
    public function getModelProductsFromIde( Request $request ) {
        $spiderIdealo = $this->container->get('app.spiderIdealo');               
        $products = $spiderIdealo->getModelProducts();
        
        
        $this->setParameters();
        $html = $this->get('twig')->render( 'template/widget_BoxListModelProductsIde.html.twig', array( 'products' => $products ) );
        
        return new Response( $html );
        
    }
    /**
     * @Route("/user/login")
     */
    public function userLogin(Request $request) {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')
                ->findOneByEmail( $request->get("email") );

        if (empty($user)) {
            return new Response(0);
        } else {
            $session = new Session();
            $session->set( 'user', $request->get("email") );

            $cacheUtility = $this->container->get('app.cacheUtility');
            $cacheUtility->initPhpCache();
            
            $cacheUtility->phpCacheSet( md5 ( $this->container->getParameter('s_memcached_prefix_userdata').$request->get( "email" ) ), $user );  
            $cacheUtility->closePhpCache();
            return new Response(1);
        }
    }

    /**
     * @Route("/user/register")
     */
    public function userRegister(Request $request) {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')
                ->findOneByEmail($request->get("email"));

        if (empty($user)) {

            $user = new User();
            $user->setName($request->get("name"));
            $user->setSurname($request->get("surname"));
            $user->setEmail($request->get("email"));
            $user->setPassword($request->get("password"));
            $user->setAge($request->get("age"));
            $user->setCity($request->get("city"));
            $user->setTel($request->get("tel"));
            $user->setTeam($request->get("team"));

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($user);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            if (empty($user->getId())) {
                return new Response(2);
            } else {
                return new Response(1);
            }
        }

        return new Response(0);
    }
    
    /**
     * @Route("/user/logout", name="userlogout")
     */
    public function userLogout(Request $request) {
        $session = new Session();
        $session->remove( 'user' );        
        header( 'Location: /' );
    
        return $this->redirectToRoute( 'homepage');
    }
    
    /**
     * @Route("/ajax/poll/{id}/{answerKey}", name="votePoll")
     */
    public function votePoll ( Request $request, $id, $answerKey ) {
        if( !isset( $answerKey ) || $answerKey == 'null' )
            return new Response(0);
        
        $this->container->get( 'app.globalTwigExtension' );
        
        $item = array();
        $totalVote = null;
        $poll = $this->getDoctrine()->getRepository('AppBundle:Poll')
                ->find( $id );        
        

        if ( !empty( $poll ) ) {
            $item['id'] = $poll->getId();
            $item['answers'] = json_decode($poll->getJsonAnswers());
            $item['question'] = $poll->getQuestion();
            $item['dataArticleId'] = $poll->getDataArticleId();
            
            if ( $answerKey == 'popUp' )
                return new Response(  $this->get('twig')->render( "/template/widget_Poll.html.twig", array(  'poll' => $item ) ) );
            
            if ( $answerKey != 'res' ) {
                $item['answers'][$answerKey]->voti = $item['answers'][$answerKey]->voti +1;
            }
            
            $poll->setJsonAnswers( json_encode( $item['answers'] ) );
            
            $em = $this->getDoctrine()->getManager();
            try {
                $em->persist($poll);
                $em->flush();
                
                foreach (json_decode( $poll->getJsonAnswers() ) as $value) {
                    $totalVote += $value->voti;
                }
                
                $item['answers'] = $this->calculatePercentage( json_decode( $poll->getJsonAnswers() ), $totalVote );
                $item['answers'] = json_decode( $item['answers'] );
                
                return new Response(  $this->get('twig')->render( "/template/widget_Poll.html.twig", array(  'poll' => $item ) ) );
                
            } catch (Exception $e) {
                return new Response(0);
            }
        }
        
        return new Response('Sondaggio non esistente!');
    }
    
    /**
     * Metodo che calcola la percentuale dei voti dei sondaggi
     * @param type $valueToCalculate
     * @param type $totalVote
     */
    private function calculatePercentage( $valueToCalculate, $totalVote ) {
        // ciclo ogni risultato delle domande del sondaggio e aggiungo il campo per la percentuale
        foreach ($valueToCalculate as $Key => $value) {
            if ( $totalVote != 0 )
                $valueToCalculate[ $Key ]->percentage = ( $valueToCalculate[ $Key ]->voti / $totalVote ) * 100;
            else
                $valueToCalculate[ $Key ]->percentage = $totalVote;
        }
        
        return json_encode( $valueToCalculate );
    }
    
     /**
     * @Route("/ajax/addLike/{articleId}/{likes}", name="addLike")
     */
    public function addLike ( Request $request, $articleId, $likes ) {
        if( !isset( $articleId ) || $articleId == 'null' )
            return new Response(0);
        
        $article = $this->getDoctrine()->getRepository('AppBundle:DataArticle')
                ->find( $articleId );

        if ( !empty( $article ) ) {
            $article->setLikes( $likes+1 );
            
            $em = $this->getDoctrine()->getManager();
            try {
                $em->persist($article);
                $em->flush();
                return new Response(1);
                
            } catch (Exception $e) {
                return new Response(0);
            }
        }
        
        return new Response(0);
    }
    
    /**
     * @Route("/ajax/addComment/{articleId}/{msg}", name="addComment")
     */
    public function addComment ( Request $request, $articleId, $msg ) {
        if( !isset( $articleId ) || $articleId == 'null' )
            return new Response(0);
        
        if( !empty( $_COOKIE['externalUserCode'] ) ) {
            $this->baseParameters();
            
            $cacheUtility = $this->container->get('app.cacheUtility');
            $externalUserId =  $cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'externalUser_'.$_COOKIE['externalUserCode'] );
            
            $externalUser = $this->getDoctrine()->getRepository('AppBundle:ExternalUser')->find( $externalUserId );
            $article = $this->getDoctrine()->getRepository('AppBundle:DataArticle')->find( $articleId );
            
            if ( !empty( $article ) ) {
                $em = $this->getDoctrine()->getManager();
                $comment = new Comment();
                $comment->setDataArticle( $article );
                $comment->setText(strip_tags( $msg ) );
                $comment->setExternalUser( $externalUser );
                $comment->setCreateAt( new \DateTime() );
                                
                try {                    
                    $em->persist($comment);
                    $em->flush();
                    
                    return new Response(  $this->get('twig')->render( "/template/snippet_Comment.html.twig", array( 'comment' => $comment ) ) );

                } catch (\Exception $e) {
                    return new Response(0);
                }
            }
        } else {
            return new Response(0);
        }        
    }
    
    /**
     * @Route("/ajax/retrieve/team", name="retrieveTeam")
     */
    public function retrieveTeam(Request $request) {
        $subcategories = $this->getDoctrine()->getRepository('AppBundle:Subcategory')->findSubcategoriesIsTeam( );
        $isTeam = array();
        
        if ( !empty( $subcategories ) ) {
            foreach ( $subcategories as $key => $team ) {
                $isTeam[$key]['id'] = $team->getId();
                $isTeam[$key]['name'] = $team->getName();
            }
        }
        
        $isTeam = json_encode( $isTeam );
        return new Response( $isTeam );
    }
    
    /**
     * @Route("/ajax/forgot/password", name="forgotPassword")
     */
    public function forgotPwd(Request $request) {
        if( empty( $_COOKIE['externalUserCode'] ) ) {
            $site = $_SERVER['HTTP_HOST'];
            $eMail = $request->query->get("resetEmail");
            
            $externalUser = $this->getDoctrine()->getRepository('AppBundle:ExternalUser')->findOneByEmail( $eMail );
            
            if ( !empty( $externalUser ) ) {
                $externalUserCode = $externalUser->getExtUserCode();
                $link = "http://".$site."/resetPassword/confirm/".$externalUserCode;
                $name = $externalUser->getName();
                $subject = "Resetta la password di ".$site;
                $message = "Ciao ".$name.", \nHai scelto di resettare la password di ".$site."\nClicca sul link sottostante per scegliere la tua nuova password. \n".$link;
                // mail(to,subject,message,headers,parameters);
                $email = mail($eMail, $subject, $message);
            }
        }
        return new Response(1);
    }
    
    /**
    * @Route("/ajax/externalUser/Logged", name="externalUserLogged")
    */
    public function externalUserLogged ( Request $request ) {
        if( empty( $_COOKIE['externalUserCode'] ) ) {
            return new Response(0);
        } else {
            return new Response(1);
        }
    }
    
    /**
    * @Route("/ajax/externalUser/Login", name="externalUserLogin")
    * @Route("/amp/ajax/externalUser/Login", name="externalUserLoginAMP")
    */
    public function externalUserlogin ( Request $request ) {
        if( empty( $_COOKIE['externalUserCode'] ) ) {
            $eMail = $request->query->get("email");
            $password = md5($request->query->get("password"));            
            $externalUser = $this->getDoctrine()->getRepository('AppBundle:ExternalUser')->findByEmailePassword( $eMail, $password );
            
            if( !empty( $externalUser ) ) {
                $mail = $externalUser->getEmail();
                $name = $externalUser->getName();
                $city = $externalUser->getCity();
                $userCode = md5($mail.$name.$city);
                setcookie("externalUserCode", $userCode, time()+3600, "/", $_SERVER['HTTP_HOST'] );
                setcookie("externalUserName", $externalUser->getName(), time()+3600, "/", $_SERVER['HTTP_HOST'] );
                
                $cacheUtility = $this->container->get('app.cacheUtility');
                $cacheUtility->initPhpCache();
                $cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'externalUser_'.$userCode , $externalUser->getId(), 3600 );
                
                return new Response(1);
            } else {
                return new Response(0);
            }
        } else {
            return new Response(2);
        }
    }
   
    /**
    * @Route("/ajax/sendRegistration/externalUser", name="sendRegistration")
    * @Route("/amp/ajax/sendRegistration/externalUser", name="sendRegistrationAMP")
    */
    public function sendRegistration ( Request $request ) {
        $team = null;
        
        if (!filter_var($request->query->get("email"), FILTER_VALIDATE_EMAIL)) {
            return new Response(3);
        }                        
        
        
        $name        = $request->query->get("name");
        $surname     = $request->query->get("surname");
        $email       = $request->query->get("email");
        $pwd         = $request->query->get("password");
        $age         = $request->query->get("age");
        $city        = $request->query->get("city");
        $privacy     = $request->query->get("privacy");
        $newsletters = $request->query->get("newsletters");

        $registerAt = new \DateTime(); 
        $newDate = $registerAt->format('d/m/Y');
        $extUserCode = md5($email.$newDate.$name);
        
        $externalUser = new ExternalUser();

        $externalUser->setName( $name );
        $externalUser->setSurname( $surname );
        $externalUser->setEmail( $email );
        $externalUser->setUsername( $name.' '.$surname );
        $externalUser->setPassword( md5( $pwd ) );
        $externalUser->setAge( $age );
        $externalUser->setCity( $city );
        $externalUser->setRegisterAt( $registerAt );
        $externalUser->setExtUserCode( $extUserCode );
        $externalUser->setPrivacy( $privacy );
        $externalUser->setNewsletters( $newsletters );
        
        $em = $this->getDoctrine()->getManager();        
        try {
            
                $em->persist($externalUser);
                $em->flush();
                
                $userCode = md5($email.$name.$city);
                setcookie("externalUserCode", $userCode, time()+3600, "/", $_SERVER['HTTP_HOST'] );
                setcookie("externalUserName", $externalUser->getName(), time()+3600, "/", $_SERVER['HTTP_HOST'] );
                $cacheUtility = $this->container->get('app.cacheUtility');
                $cacheUtility->initPhpCache();
                $cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'externalUser_'.$userCode , $externalUser->getId(), 3600 );
                
                if( $newsletters == 1 ) {
                    $aEmail = explode( '@', $email );
                    $response = new GetResponseManager('4d10653de108ab95034f7e52c6091af3');
                    $campaign = array('campaignId'=>'amk3v');
                    $params = array(
                        'email' => $email,
                        'campaign' => $campaign,
                        'name' => $aEmail[0],
                        'ipAddress' => ( !empty( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '' )
                    );
                    $result = $response->addContact($params);  
                }
                
                return new Response(1);

            } catch ( \Exception $e ) {
                
                switch (get_class($e)) {
                    case 'Doctrine\DBAL\Exception\UniqueConstraintViolationException':
                            return new Response(2);
                        break;
                    default:
                        return new Response($e);
                        break;
                }
            }
    }
    
    /**
    * @Route("/ajax/sendRegistration/externalUserSocial", name="loginWithSocial")
    * @Route("/amp/ajax/sendRegistration/externalUserSocial", name="loginWithSocialAMP")
    */
    public function loginWithSocial ( Request $request ) {                        
        if( empty( $_COOKIE['externalUserCode'] ) ) {
            $em             = $this->getDoctrine()->getManager();
            $pathToWrite    = $this->container->getParameter('app.folder_imgExternalUser_default_write');
            $width          = $this->container->getParameter('app.imgExternalUser_default_width');
            $height         = $this->container->getParameter('app.imgExternalUser_default_height');
            $accessToken    = null;
            $userID         = null;
            $profileImg     = null;
            $team           = null;
            $social         = $request->query->get('action');
            $authResponse   = json_decode( $request->query->get("authResponse") );
            
            if( $social == 'Facebook' ) {
                $usr            = json_decode( $request->query->get("userFb") );
                $accessToken    = $authResponse->accessToken;
                $userID         = $authResponse->userID;
                $profileImg     = $usr->picture;
                
            } else {
                $usr            = json_decode( $request->query->get("userGoogle") );
                $accessToken    = $request->query->get("access_token");
                $userID         = $usr->id;
                $profileImg     = $usr->picture;
            }
            
//            print_r( $usr );
            
            $usrInfo        = explode(' ', $usr->name);
            $userCode       = md5($userID.'_'.$social);

            $externalUser = $this->getDoctrine()->getRepository('AppBundle:ExternalUser')->findByUserCode( $userCode );
            
            if( empty( $externalUser ) ) {
                $imageUtility   = $this->container->get('app.imageUtility');
                $myFile = array();
                $myFile['name'][0] = $profileImg;
                $myFile['tmp_name'][0] = $profileImg;
                $myFile['type'][0] = $imageUtility->myGetTypeImg( $profileImg );
                
                $photo = $imageUtility->myUpload( $myFile, $pathToWrite, '/tmp/', $width, $height, 'externalUser' );
                $pathFoto = $photo['foto'][0];
                
                $name           = $usrInfo[0];
                $surname        = $usrInfo[1];
                $email          = !empty( $usr->email ) ? $usr->email : '';
                if( empty( $email ) )
                    return new Response(5);
                
                $registerAt     = new \DateTime();
                
                $externalUser = new ExternalUser();
                $externalUser->setName( $name );
                $externalUser->setSurname( $surname );
                $externalUser->setUsername( $name.' '.$surname );
                $externalUser->setEmail( $email );
                $externalUser->setPassword( md5( date('Y-m-d H:i') ) );
                $externalUser->setTeam( $team );
                $externalUser->setRegisterAt( $registerAt );
                $externalUser->setExtUserCode( $userCode );
                $externalUser->setAccessToken( $accessToken );
                $externalUser->setProfileImg( $pathFoto );
                $externalUser->setPrivacy( 1 );
                $externalUser->setNewsletters( 1 ); 
               
                try {
                        $em->persist($externalUser);
                        $em->flush();

                        setcookie("externalUserCode", $userCode, time()+3600, "/", $_SERVER['HTTP_HOST'] );
                        setcookie("externalUserName", $externalUser->getName(), time()+3600, "/", $_SERVER['HTTP_HOST'] );

                        $cacheUtility = $this->container->get('app.cacheUtility');
                        $cacheUtility->initPhpCache();
                        $cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'externalUser_'.$userCode , $externalUser->getId(), 3600 );
                        
                        $response = new GetResponseManager('4d10653de108ab95034f7e52c6091af3');
                        $campaign = array('campaignId'=>'amk3v');
                        $params = array(
                            'email' => $email,
                            'campaign' => $campaign,
                            'name' => $name.' '.$surname,
                            'ipAddress' => ( !empty( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '' )
                        );
                        $result = $response->addContact($params);                        
                        return new Response(1);

                    } catch ( \Exception $e ) {

                        switch (get_class($e)) {
                            case 'Doctrine\DBAL\Exception\UniqueConstraintViolationException':
                                    return new Response(2);
                                break;
                            default:
                                return new Response($e);
                                break;
                        }
                    }
            } else {
                setcookie("externalUserCode", $userCode, time()+3600, "/", $_SERVER['HTTP_HOST'] );
                setcookie("externalUserName", $externalUser->getName(), time()+3600, "/", $_SERVER['HTTP_HOST'] );                
                $cacheUtility = $this->container->get('app.cacheUtility');
                $cacheUtility->initPhpCache();
                $cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'externalUser_'.$userCode , $externalUser->getId(), 3600 );
                
                $externalUser->setAccessToken($accessToken);
                $em->persist($externalUser);
                $em->flush();
                return new Response(1);
            }
        } else {
            return new Response(1);
        }
    }
    
    /**
     * @Route("/extUser/logout", name="userlogout")
     * @Route("/amp/extUser/logout", name="userlogoutAMP")
     */
    public function userLogoutAction(Request $request) {        
        
        $cacheUtility = $this->container->get('app.cacheUtility');
        $cacheUtility->initPhpCache();
        $cacheUtility->removeKey( false, $this->container->getParameter( 'session_memcached_prefix' ).'externalUser_'.$_COOKIE["externalUserCode"] );
        
        setcookie("externalUserCode", $_COOKIE['externalUserCode'], time()-3600, "/", $_SERVER['HTTP_HOST'] );
        
        unset( $_COOKIE["externalUserName"] );
        return $this->redirectToRoute( 'homepage');
    }
    
    /**
     * @Route("/ajax/sendNewsletters", name="sendNewsletters")
     */
    public function sendNewslettersAction(Request $request) {  
        $email = $request->query->get("email");
                
        
        if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            return new Response();
        }     
                
        $item = $this->getDoctrine()->getRepository('AppBundle:Newsletter')->findByEmail( $email );
        if( !empty( $item ) ) {
            return new Response(0);
        }
        
        $newsletter = new Newsletter();               
        $newsletter->setEmail( $email );                
               
        
        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $newsletter );
            $em->flush();
            
            $aEmail = explode( '@', $email );
            $response = new GetResponseManager('4d10653de108ab95034f7e52c6091af3');
            $campaign = array('campaignId'=>'amk3v');
            $params = array(
                'email' => $email,
                'campaign' => $campaign,
                'name' => $aEmail[0],
                'ipAddress' => ( !empty( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '' )
            );
            $result = $response->addContact($params);                        
            return new Response(1);
            
        } catch ( \Exception $e ) {
            switch ( get_class( $e ) ) {
                case 'Doctrine\DBAL\Exception\UniqueConstraintViolationException':
                        return new Response( 2 );
                    break;
                default:
                    return new Response( $e );
                    break;
            }
        }
        exit;
        return new Response( $html );
    }
    /**
     * @Route("/amp/ajax/sendNewsletters", name="sendNewslettersAMP")
     */
    public function sendNewslettersAMPAction(Request $request) {  
        $domain_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        header("Content-type: application/json");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Origin: ". str_replace('.', '-','https://example.com') .".cdn.ampproject.org");
        header("AMP-Access-Control-Allow-Source-Origin: " . $domain_url);
        header("Access-Control-Expose-Headers: AMP-Access-Control-Allow-Source-Origin");
//        header("AMP-Redirect-To: https://example.com/thankyou.amp.html");
//        header("Access-Control-Expose-Headers: AMP-Redirect-To, AMP-Access-Control-Allow-Source-Origin"); 
        
        $email = $request->query->get("email");
                
        
        if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            return new Response('{"verifyErrors":[{"message":"Indirizzo email non valido","name":"username"}]}', 400);
        }     
                
        $item = $this->getDoctrine()->getRepository('AppBundle:Newsletter')->findByEmail( $email );
        if( !empty( $item ) ) {
            return new Response('{"verifyErrors":[{"message":"Indirizzo email già presente","name":"username"}]}', 400);
        }
        
        $newsletter = new Newsletter();               
        $newsletter->setEmail( $email );                
               
        
        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $newsletter );
            $em->flush();
            
            $aEmail = explode( '@', $email );
            $response = new GetResponseManager('4d10653de108ab95034f7e52c6091af3');
            $campaign = array('campaignId'=>'amk3v');
            $params = array(
                'email' => $email,
                'campaign' => $campaign,
                'name' => $aEmail[0],
                'ipAddress' => ( !empty( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '' )
            );
            $result = $response->addContact($params);                        
            return new Response('{"email":"'.$email.'"}', 200);
            
        } catch ( \Exception $e ) {
            switch ( get_class( $e ) ) {
                case 'Doctrine\DBAL\Exception\UniqueConstraintViolationException':
                        return new Response('{"verifyErrors":[{"message":"Indirizzo email già presente","name":"username}]}', 400);
                    break;
                default:
                    return new Response( $e );
                    break;
            }
        }
        exit;
        return new Response( $html );
    }
    
    /**
     * @Route("/ajax/getLoginHtml", name="getLoginHtmlAction")
     */
    public function getLoginHtmlAction(Request $request) {  
        $html = $this->get('twig')->render( 'template/widget_Login.html.twig' );
        return new Response( $html );
    }
    
    
}

//{"name": "Jan Kowalski","email": "jan.kowalski@wp.pl","campaign": {"campaignId": "amk3v"}