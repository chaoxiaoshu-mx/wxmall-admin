var request=(params)=>{
	const baseUrl = 'http://wxmall.test/api'
	return new Promise(( resolve,reject )=>{
		wx.request({
			...params,
			url: baseUrl+params.url,
			success:(result)=>{
				resolve(result);
			},
			fail:(err)=>{
				reject(err);
			}
		})
	});
}