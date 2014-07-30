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
			getShortURL : function(url) {
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
