<?php
    namespace ImapServer;
    
    require_once( $_SERVER[ "DOCUMENT_ROOT" ] . "/MailHeader.class.php" );

    class Mailbox{
        protected $name;
        protected $headerList;
        protected $messageCount;
        public function __construct( $connection, $name, $criteria ){
            $this->name = $name;
            $this->headerList = array();
            $this->get( $connection, $criteria );
        }
        private function get( $connection, $criteria ){
            $listUid = imap_search( $connection, $criteria );
            if( $listUid === false ){
                $this->messageCount = 0;                
            }
            else{
                $this->messageCount = count( $listUid );                
                foreach( $listUid as $uid ){    
                    $header = imap_headerinfo( $connection, $uid );      
                    if( is_object( $header ) ){
                      $this->headerList[] = new MailHeader( $header );                    
                    }
                }        
            }
        }  
        public function getHeaderList(){
            return $this->headerList;
        }
        public function getMessageCount(){
            return $this->messageCount;
        }
        public function isExistMessage(){
            return ( $this->messageCount > 0 );
        }        
    }
// eof    