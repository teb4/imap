<?php
    namespace ImapServer;
    
    require_once( $_SERVER[ "DOCUMENT_ROOT" ] . "/MailDate.class.php" );
    require_once( $_SERVER[ "DOCUMENT_ROOT" ] . "/MailSubject.class.php" );
    require_once( $_SERVER[ "DOCUMENT_ROOT" ] . "/MailFromAddress.class.php" );
    require_once( $_SERVER[ "DOCUMENT_ROOT" ] . "/MailFrom.class.php" );    

    class MailHeader{
        protected $date;
        protected $subject;
        protected $author;
        protected $from;

        public function __construct( $header ){
            $this->date = MailDate::get( $header );
            $this->subject = MailSubject::get( $header );
            $this->author = MailFromAddress::get( $header );
            $this->from = MailFrom::get( $header );
        }
        public function out(){
            print '<tr>';
            print '<td> ' . date( 'd-m-Y', $this->date ) . '</td>';
            print '<td> ' . $this->subject . '</td>';
            print '<td> ' . $this->author . '</td>';
            print '<td> ' . $this->from . '</td>';
            print '</tr>';                 
        }
    }
// eof    