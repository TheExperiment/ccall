function ShortBitlyURL(json) {
	this.global_hash	 = json.data.global_hash;
	this.hash			 = json.data.hash;
	this.long_url		 = json.data.long_url;
	this.new_hash		 = json.data.new_hash;
	this.url			 = json.data.url;
}