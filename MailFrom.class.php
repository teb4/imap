<?php
    namespace ImapServer;
    
    class MailFrom{
        public static function get( $header ){
            $result = '';
            if( isset( $header->from  ) ){
                $from = $header->from;
                $from = $from[ 0 ];
                $result = $from->mailbox . '@' . $from->host;
            }
            return $result;
        }
    }
// eof    