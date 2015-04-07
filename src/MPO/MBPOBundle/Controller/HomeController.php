<?php

namespace MPO\MBPOBundle\Controller;

require_once ("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PdoGsb;

class HomeController extends Controller
{
    public function indexAction()
    {
        $pdo = PdoGsb::getPdoGsb();
        $lesActivites=$pdo->AffActivite();
        return $this->render('MPOMBPOBundle:Home:index.html.twig',array('listeActivites'=>$lesActivites));
    }
    
    public function connexionAction()
    {
        return $this->render('MPOMBPOBundle:Home:connexion.html.twig');
    }
    
    public function validerconnexionAction()
    {
        $session = $this->get('request')->getSession();
        $request = $this->get('request');
        $login = $request->request->get('login');
        $mdp = $request->request->get('mdp');
        $pdo = PdoGsb::getPdoGsb();
        $user = $pdo->getUser($login,$mdp);
        if(!is_array($user)){
            return $this->render('MPOMBPOBundle:Home:connexion.html.twig',array(
                'message'=>'Erreur de login ou de mot de passe'));
        
        }
        else {
            return $this->render('MPOMBPOBundle:Home:activite.html.twig');
        }
        
    }
    
    public function deconnexionAction()
    {
        $session = $this->get('request')->getSession();
        $session->clear();
        $pdo = PdoGsb::getPdoGsb();
        $lesActivites=$pdo->AffActivite();
        return $this->render('MPOMBPOBundle:Home:index.html.twig',array('listeActivites'=>$lesActivites));
    }
    
    public function addactiviteAction()
    {
        $pdo = PdoGsb::getPdoGsb();
        $request = $this->get('request');
        $nom = $request->request->get('name');
        $libelle = $request->request->get('libelle');
        $desc = $request->request->get('desc');
        $img = $request->request->get('img');
        if($nom != "" && $libelle != "" && $desc != "" && $img != ""){
            $addActivite = $pdo->addActivite($nom,$libelle,$desc,$img);
            return $this->render('MPOMBPOBundle:Home:activite.html.twig',array(
                'success'=>'Activité ajoutée =).'));
        }
        else {
            return $this->render('MPOMBPOBundle:Home:activite.html.twig',array(
                'error'=>'Erreur'));
        }
        
    }
    
}
