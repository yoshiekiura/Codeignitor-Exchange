<table style="background-color: rgb(255, 255, 255);" width="100%">
  <tbody>
   <tr>
      <td style="padding: 20px 30px 5px;">
      <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">Dear <?php echo (isset($username))?$username:'' ?>,</h2>

     <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 14px; text-align: left; padding: 15px 0px;"><span style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 13px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;">We received a request to withdraw <?php echo (isset($amount))?$amount:'' ?>&nbsp;<?php echo (isset($currency))?$currency:'' ?> on purse <?php echo (isset($purse))?$purse:'' ?></span></p>

     <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 14px; text-align: left; padding: 15px 0px;"><span style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 13px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;">To confirm the transaction, go to: <a href='<?php echo (isset($confirmlink))? $confirmlink : "" ?>'>Confirm Link</a></span></p>

     <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 14px; text-align: left; padding: 15px 0px;"><span style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 13px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;">To cancel a transaction, go to:&nbsp; <a href='<?php echo (isset($cancellink))?$cancellink:"" ?>'>Cancel Link</a></span></p>

     <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 14px; text-align: left; padding: 15px 0px;">IP: <?php echo (isset($ip))?$ip:'' ?></p>

      <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 14px; text-align: left; padding: 15px 0px;">LOGIN: <?php echo (isset($login))?$login:'' ?></p>
     </td>
   </tr>
 </tbody>
</table>