<?php
$this->load->view('mails/email_header');
?>
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="45" class="em_height" style="font-size:1px; line-height:1px;">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle" style="font-family:'Futura LT', Arial, sans-serif; font-size:15px; line-height:18px; color:#000000; letter-spacing:2px;">WELCOME</td>
  </tr>
  <tr>
    <td height="35" class="em_height" style="font-size:1px; line-height:1px;">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle" style="font-family:'Futura LT', Arial, sans-serif; font-size:15px; line-height:18px; color:#000000;">
        <p>Hi <?php echo $user->name;?>,</p>
        <p>To reset password please click on below button</p>
    </td>
  </tr>
  <tr>
    <td height="45" class="em_height" style="font-size:1px; line-height:1px;">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">
      <table align="center" width="220" border="0" cellspacing="0" cellpadding="0" background="<?php echo img_url(); ?>img_btn_bg.jpg" style="background-position:center top; background-repeat:no-repeat;">
      
        <tr>
          <td valign="top">
            <table align="center" width="220" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right" valign="top" style="font-size:0px; line-height:0px;" width="6"><img src="<?php echo img_url(); ?>img_curve1.jpg" width="6" height="6" border="0" style="display:block;" alt=""/></td>
                <td height="6" width="208" bgcolor="#000000" style="font-size:0px; line-height:0px;"><img src="<?php echo img_url(); ?>spacer.gif" width="1" height="1" border="0" style="display:block;" alt=""/></td>
                <td align="left" valign="top" style="font-size:0px; line-height:0px;" width="6"><img src="<?php echo img_url(); ?>img_curve2.jpg" width="6" height="6" border="0" style="display:block;" alt=""/></td>
              </tr>
            </table>
          </td>
        </tr>
        
        <tr>
          <td align="center" width="220" valign="middle" height="24" style="font-family:'Futura LT', Arial, sans-serif; font-size:12px; color:#ffffff; text-transform:uppercase; letter-spacing:2px;" bgcolor="#000000"><a href="<?php echo base_url();?>set-password/<?php echo $token;?>" target="_blank" style="color:#ffffff; text-decoration:none; line-height:22px; display:block;">RESET PASSWORD</a></td>
        </tr>
        
        <tr>
          <td valign="top">
            <table align="center" width="220" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right" valign="bottom" style="font-size:0px; line-height:0px;" width="6"><img src="<?php echo img_url(); ?>img_curve3.jpg" width="6" height="6" border="0" style="display:block;" alt=""/></td>
                <td height="6" width="208" bgcolor="#000000" style="font-size:0px; line-height:0px;"><img src="<?php echo img_url(); ?>spacer.gif" width="1" height="1" border="0" style="display:block;" alt=""/></td>
                <td align="left" valign="bottom" style="font-size:0px; line-height:0px;" width="6"><img src="<?php echo img_url(); ?>img_curve4.jpg" width="6" height="6" border="0" style="display:block;" alt=""/></td>
              </tr>
            </table>
          </td>
        </tr>
        
      </table>
    </td>
  </tr>
  <tr>
    <td height="45" class="em_height" style="font-size:1px; line-height:1px;">&nbsp;</td>
  </tr>
</table>
<?php
$this->load->view('mails/email_footer');
?>


