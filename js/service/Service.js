var Service = (function() {

	// Instance stores a reference to the Singleton
	var serviceInstance;

	function init() {

		jQuery.urlShortener.settings.apiKey = 'AIzaSyCZJB8FLx9dguZ3sngkRm0IHArYhUJQ-bY';

		function triggerShortURLDataComplete(newData) {
			$(serviceInstance).trigger("shortURLDataSuccess", {
				data : newData
			});
		}

		return {
			//POST to get the shortened URL from google url shortner
			getGoogleShortURL : function(url) {
				jQuery.urlShortener({
					longUrl : url,
					success : function(shortUrl) {
						var vo = new ShortURL(shortUrl);
						triggerShortURLDataComplete(vo);
					},
					error : function(err) {
						alert(JSON.stringify(err));
					}
				});
			},
			getBitlyShortURL : function(url) {				
				var accessToken = 'dd6b946298e9c97e03da6ba021c017cc106033f9';
   				var url = 'https://api-ssl.bitly.com/v3/shorten?access_token=' + accessToken + '&longUrl=' + encodeURIComponent(url);
				
				$.ajax({
				  dataType: "json",
				  url: url,
				  async: false,
				  success: function(response)
			        {
			        	console.log(response);
			        	var vo = new ShortBitlyURL(response);
						triggerShortURLDataComplete(vo);
			        }
				});
			}
		};
	};

	return {
		// Get the Singleton serviceInstance if one exists
		// or create one if it doesn't
		getInstance : function() {

			if (!serviceInstance) {
				serviceInstance = init();
			}

			return serviceInstance;
		}
	};

})();
/*
 ============================
 API Endpoints and Urls
 ============================

 Request
 AIzaSyCZJB8FLx9dguZ3sngkRm0IHArYhUJQ-bY
 https://www.googleapis.com/urlshortener/v1/url
 Content-Type: application/json
 {"longUrl": "http://www.google.com/"}

 Response
 {
 "kind": "urlshortener#url",
 "id": "http://goo.gl/fbsS",
 "longUrl": "http://www.google.com/"
 }

 */
