const request=(params)=>{
	const baseUrl = 'http://wxmall.test/api'
	return new Promise(( resolve,reject )=>{
		$.ajax({
			...params,
			"url": baseUrl + params.url,
			success:(result)=>{
				resolve(result);
			},
			fail:(err)=>{
				reject(err);
			}
		})
	});
}