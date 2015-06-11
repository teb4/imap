<?php
    namespace ImapServer;
    
    class MailSubject{
        public static function get( $header ){
            $result = '';
            if( isset( $header->subject  ) ){
                $value = imap_mime_header_decode( $header->subject );
                $result = $value[ 0 ]->text;
            }
            elseif( isset( $header->Subject  ) ){
                $value = imap_mime_header_decode( $header->Subject );
                $result = $value[ 0 ]->text;
            }
            else{
                $result = '';
            }
            return $result;
        }
    }
// eof    