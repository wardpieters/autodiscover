<?php

header('Content-Type: application/xml');
$raw = file_get_contents('php://input');
$imap_server = getenv('IMAP_HOST');
$imap_ssl = getenv('IMAP_SSL');
$smtp_server = getenv('SMTP_HOST');

$matches = array();
preg_match('/<EMailAddress>(.*)<\/EMailAddress>/', $raw, $matches);
?>
<?xml version="1.0" encoding="utf-8" ?>
<Autodiscover xmlns="http://schemas.microsoft.com/exchange/autodiscover/responseschema/2006">
  <Response xmlns="http://schemas.microsoft.com/exchange/autodiscover/outlook/responseschema/2006a">
    <Account>
      <AccountType>email</AccountType>
      <Action>settings</Action>
      <Protocol>
        <Type>IMAP</Type>
        <Server><?= $imap_server ?></Server>
        <Port>993</Port>
        <DomainRequired>off</DomainRequired><?= (empty($matches)) ? "\n" : PHP_EOL . "<LoginName>" . $matches[1] . "</LoginName>" ?>
        <SPA>on</SPA>
        <SSL><?= $imap_ssl == true ? "on" : "off" ?></SSL>
        <AuthRequired>on</AuthRequired>
      </Protocol>
      <Protocol>
        <Type>SMTP</Type>
        <Server><?= $smtp_server ?></Server>
        <Port>587</Port>
        <DomainRequired>off</DomainRequired><?= (empty($matches)) ? "\n" : PHP_EOL . "<LoginName>" . $matches[1] . "</LoginName>" ?>
        <SPA>off</SPA>
        <Encryption>off</Encryption>
        <AuthRequired>on</AuthRequired>
        <UsePOPAuth>off</UsePOPAuth>
        <SMTPLast>off</SMTPLast>
      </Protocol>
    </Account>
  </Response>
</Autodiscover>
