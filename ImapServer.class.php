<?php
    namespace ImapServer;
    
    require_once( $_SERVER[ "DOCUMENT_ROOT" ] . "/MailBox.class.php" );
    
    class ImapServer{
        protected $host;
        protected $port  =  993;
        protected $param = '/imap/ssl/novalidate-cert/readonly';
        protected $request;        
        protected $connection;
        public function __construct( $host, $login, $pass ){
            $this->host = $host;
            $this->request = "{"."{$this->host}:{$this->port}{$this->param}"."}";        
            $this->connect( $login, $pass );
        }
        public function connect( $login, $pass ){
            $this->connection = @imap_open( $this->request, $login, $pass );
        }
        public function getError(){
            return imap_last_error();
        }
        public function getMailboxNameList(){
            $mailBoxList = array();
            $list = imap_list( $this->connection, $this->request, "*" );
            if( is_array( $list ) ){
                foreach( $list as $rawMailboxName ){       
                    $mailBoxList[] = $this->extractMailboxName( $rawMailboxName );
                }   
            }
            else{
                throw new Exception( "imap_list failed: " . imap_last_error() );
            }
            return $mailBoxList;
        }
        private function extractMailboxName( $rawMailboxName ){
            return str_replace( $this->request, '', mb_convert_encoding( $rawMailboxName, "UTF-8", "UTF7-IMAP" ) );
        }
        public function openMailbox( $mailboxName, $criteria ){
            imap_reopen( $this->connection, $this->request . $mailboxName );                  
            return new Mailbox( $this->connection, $mailboxName, $criteria );            
        }
        public function closeConnection(){
            imap_close( $this->connection ); 
        }
        public function isConnected(){
            $result = true;
            if( $this->connection === false ){
                $result = false;
            }
            return $result;
        }
    }
// eof    