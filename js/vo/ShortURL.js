function ShortURL(json) {
	this.kind = json.kind;
	this.id = json.id;
	this.longUrl = json.longUrl;
}


/*
	{
	 "kind": "urlshortener#url",
	 "id": "http://goo.gl/fbsS",
	 "longUrl": "http://www.google.com/"
	}
 */