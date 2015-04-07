<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=mbpo';   		
      	private static $user='root' ;    		
      	private static $mdp='' ;	
		private static $monPdo;
		private static $monPdoGsb=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la classe
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}
/**
 * Cette fonction retourne les informations d'un user
 
 * @param $login 
 * @param $mdp
 * @return l'id, le login sous la forme d'un tableau associatif 
*/
	public function getUser($login, $mdp)
        {
            $res = PdoGsb::$monPdo->prepare
            ("SELECT idUser, login FROM USER "
             ."WHERE login = :login AND mdp = :mdp ");
            $res->bindValue('login', $login);
            $res->bindValue('mdp', $mdp);
            $res->execute();
            $Ligne = $res->fetch();
            return $Ligne;
	}

/**
 * 
*/
	
        public function affActivite()
        {
            $res = PdoGsb::$monPdo->prepare
            ("SELECT * FROM ACTIVITE");
            $res->execute();
            $lesLignes = $res->fetchAll();
            return $lesLignes;
        }
        
        public function addActivite($nom,$libelle,$desc,$img)
        {
            $res = PdoGsb::$monPdo->prepare
            ("INSERT INTO ACTIVITE "
            ."VALUES(:nom, :libelle, :desc, :img) ");
            $res->bindValue('nom', $nom);
            $res->bindValue('libelle', $libelle);
            $res->bindValue('desc', $desc);
            $res->bindValue('img', $img);
            $res->execute();
        }
}
?>