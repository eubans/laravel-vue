<!doctype html>
<html>
<!-- HEADER -->
@include('mail.html.layout.header')
<link rel="stylesheet" href="{{ asset('css/mail.css') }}">

<body>
  <!-- This is preheader text. Some clients will show this text as a preview.  -->

  <!-- Visually Hidden Preheader Text : BEGIN -->
  <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">
    This is a mail from PrimeTech
  </div>
  <!-- Visually Hidden Preheader Text : END -->

  <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
    <tr>
      <td>&nbsp;</td>
      <td class="container">
        <div class="content">

          <!-- START CENTERED WHITE CONTAINER -->
          <table role="presentation" class="main">
            <tr>
              <td class="wrapper">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>

                    <!-- START MAIN CONTENT AREA -->
                      <p>Hi there,</p>
                      <p>Sometimes you just want to send a simple HTML email with a simple design and clear call to action. This is it.</p>
                      <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                          <tbody>
                          <tr>
                              <td align="left">
                              <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                  <tbody>
                                  <tr>
                                      <td> <a href="http://htmlemail.io" target="_blank">Call To Action</a> </td>
                                  </tr>
                                  </tbody>
                              </table>
                              </td>
                          </tr>
                          </tbody>
                      </table>
                      <p>This is a really simple email template. Its sole purpose is to get the recipient to click the button with no distractions.</p>
                      <p>Good luck! Hope it works.</p>
                    <!-- END MAIN CONTENT AREA -->

                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!-- END CENTERED WHITE CONTAINER -->

          <!-- FOOTER -->
          @include('mail.html.layout.footer')

        </div>
      </td>
      <td>&nbsp;</td>
    </tr>
  </table>
</body>
</html>
