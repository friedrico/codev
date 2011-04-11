<?php if (!isset($_SESSION)) { session_start(); } ?>

<?php
// ==============================================================
class IssueCache {
   
    // instance de la classe
    private static $instance;
    private static $objects;
    private static $callCount;
    private static $cacheName;

    // Un constructeur priv� ; emp�che la cr�ation directe d'objet
    private function __construct() 
    {
        self::$objects = array();
        self::$callCount = array();
        
        self::$cacheName = __CLASS__;
        #echo "DEBUG: Cache ready<br/>";
    }

    // La m�thode singleton
    public static function getInstance() 
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }
   

    /**
     * get Issue class instance
     * @param $bugId
     */
    public function getIssue($bugId)
    {
        $issue = self::$objects[$bugId];
        
        if (NULL == $issue) {
            self::$objects[$bugId] = new Issue($bugId);
            $issue = self::$objects[$bugId];
            
            #echo "DEBUG: IssueCache add $bugId<br/>";
        } else {
            self::$callCount[$bugId] += 1;
        	   #echo "DEBUG: IssueCache called $bugId<br/>";
        }
        return $issue;
    }
    
    public function displayStats() {
    	echo "=== ".self::$cacheName." Statistics ===<br/>\n";
    	echo "nb objects in cache : ".count(self::$callCount)."<br/>\n";
      echo "nb cache calls     : ".array_sum(self::$callCount)."<br/>\n";
      echo "<br/>\n";
      foreach(self::$callCount as $bugId => $count) {
      	echo "cache[$bugId] = $count<br/>\n";
      }
    	
    }
    
    
} // class Cache

?>