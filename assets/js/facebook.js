function login(control) { 
    if(jQuery(control).hasClass('disabled'))
    {
        FB.login(function(response) {
            console.log('access_token '+response.authResponse.accessToken);
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
                        ids[i]=data[i].id;
                        access_token[i] = data[i].access_token;
                    }
                    console.log('page_access_token '+access_token[1]);

                    FB.api(
                        "/"+ids[1]+"/feed",
                        "POST",
                        {
                            "message": "This is a test message by Ninad",
                            access_token : access_token[1]
                        },
                        function (response) {
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

