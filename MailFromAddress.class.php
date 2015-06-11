<?php
    namespace ImapServer;
    
    class MailFromAddress{
        public static function get( $header ){
            $result = '';
            if( isset( $header->fromaddress  ) ){
                $value = imap_mime_header_decode( $header->fromaddress );
                $result = $value[ 0 ]->text;
            }
            return $result;
        }
    }    
// eof    