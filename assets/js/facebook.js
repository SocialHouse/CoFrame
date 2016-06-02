
  // // This is called with the results from from FB.getLoginStatus().
  // function statusChangeCallback(response) {        
  //   if (response.status === 'connected') {
  //     jQuery.ajax({
  //         type: 'POST',
  //         url: base_url+'social_media/save_fb_data',
  //         data: response,
  //         success: function(content)
  //         {
  //           jQuery('#test').hide();
  //         }

  //       });
  //       testAPI();
  //   } else if (response.status === 'not_authorized') {
  //     jQuery('#test').show();
  //     // The person is logged into Facebook, but not your app.
  //     document.getElementById('status').innerHTML = 'Please log ' +
  //       'into this app.';
  //   } else {
  //     // The person is not logged into Facebook, so we're not sure if
  //     // they are logged into this app or not.
  //     jQuery('#test').show();
  //     document.getElementById('status').innerHTML = 'Please log ' +
  //       'into Facebook.';
  //   }
  // }

  // // This function is called when someone finishes with the Login
  // // Button.  See the onlogin handler attached to it in the sample
  // // code below.
  // function checkLoginState() {
  //   alert('test');
  //   FB.getLoginStatus(function(response) {
  //     statusChangeCallback(response);
  //   });
  // }

function login(control) { 
    if(jQuery(control).hasClass('disabled'))
    {
        FB.login(function(response) {
            console.log(response);
            if (response.authResponse) 
            {
                jQuery('#'+jQuery(control).data('selected-outlet-id')).val(JSON.stringify(response));
                // FB.api('/me/accounts', function(response) {
                //   console.log(response);
                // });

                FB.api('/me/accounts',function(apiresponse){
                    var data=apiresponse['data'];
                    var ids = new Array();
                    var access_token = new Array();
                    for(var i=0; i<data.length; i++){
                        console.log(data[i]);
                        ids[i]=data[i].id;
                        access_token[i] = data[i].access_token;
                    }
                    console.log(ids);

                    FB.api(
                        "/"+ids[1]+"/feed",
                        "POST",
                        {
                            "message": "This is a test message",
                            access_token : access_token[1]
                        },
                        function (response) {
                            console.log(response);
                          if (response && !response.error) {
                            /* handle the result */
                          }
                        }
                    );

                },{'scope':'manage_pages,publish_pages'});
            } 
            else {
                if(jQuery(control).hasClass('selected'))
                {
                    jQuery(control).removeClass('selected');
                    jQuery(control).addClass('disabled');
                }

            }
        },{'scope':'public_profile,email,manage_pages,publish_pages'});
    }    
}

window.fbAsyncInit = function() {
    FB.init({
    appId      : '1711815429100433',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.5' // use graph api version 2.5
});

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  // FB.getLoginStatus(function(response) {
  //   statusChangeCallback(response);
  // });

  };

// Load the SDK asynchronously
(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function testAPI() {
FB.api('/me', function(response) {
  console.log(response);
  console.log('Successful login for: ' + response.name);
  document.getElementById('status').innerHTML =
    'Thanks for logging in, ' + response.name + '!';        
});
}

