<?php
    ini_set( 'display_startup_errors', 1 );
    ini_set( 'display_errors', 1 );
    error_reporting( -1 );
    error_reporting( E_ALL & ~E_STRICT );
    
    require_once( $_SERVER[ "DOCUMENT_ROOT" ] . "/ImapServer.class.php" );
    use ImapServer\ImapServer;

    $host  = 'imap.mail.ru';
    $login = '';
    $pass  = '';    
    //$criteria = 'SINCE "01 january 2015"';      
    $criteria = 'ALL';    
    $imapServer = new ImapServer( $host, $login, $pass );
    if( $imapServer->isConnected() ){    
        print '<div style="text-align:center; color: yellow; background-color: blue;">IMAP server ' . $host . ' connected</div>';
        print '<table border="1" style="position: relative; left: +45%; top: +30px;">';
        print '<tr><td>Mailbox list</td></tr>';    
        $nameList = $imapServer->getMailboxNameList();
        foreach( $nameList as $name ){
            print '<tr><td>' . $name . '</td></tr>';
        }
        print '</table>';
         
        foreach( $nameList as $name ){
            $mailbox = $imapServer->openMailbox( $name, $criteria );
            print '<table border="1" style="position: relative; top: +40px; width: 100%">';
            print '<tr><td style="width: 50%">Mailbox:</td><td style="width: 50%">'. $name . '</td></tr>';        
            if( $mailbox->isExistMessage() ){
                print '<tr><td>Всего сообщений:</td><td>' . $mailbox->getMessageCount() . '</td></tr>';                   
                printHeaderList( $mailbox );
            }            
            else{
                print '<tr><td>Нет сообщений</td></tr>';
            }             
            print '</table>';
        }
        $imapServer->closeConnection();        
    }
    else{                 
        print "Can't connect: " . $imapServer->getError() ."<br />";          
    };      
    
    function printHeaderList( $mailbox ){                 
            print '<tr><td>Date</td><td>Subject</td><td>Author</td><td>From</td></tr>';
            $headerList = $mailbox->getHeaderList();        
            foreach( $headerList as $header ){
                $header->out();
            }                
    }
// eof