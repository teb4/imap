<?php
    namespace ImapServer;
    
    class MailDate{
        public static function get( $header ){
            $result = 0;
            if( isset( $header->udate  ) ){
                $result = $header->udate;
            }             
            return $result;
        }
    }
// eof    