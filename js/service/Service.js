var Service = (function() {

	// Instance stores a reference to the Singleton
	var serviceInstance;

	function init() {

		function triggerShortURLDataComplete(newData) {
			$(serviceInstance).trigger("shortURLDataSuccess", {
				data : newData
			});
		}

		return {
			//POST to get the shortened URL from google url shortner
			getShortURL : function(url) {
				var reqURL = "https://www.googleapis.com/urlshortener/v1/url";
				$.ajax({
					url : reqURL,
					type : 'post',
					data : {
						longUrl : url,
						key : 'AIzaSyCZJB8FLx9dguZ3sngkRm0IHArYhUJQ-bY'
					},
					headers : {
						//
					},
					dataType : 'json',
					success : function(result) {
						var vo = new ShortURL(result);
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
