const currencyFormatter = (data, code) => {
    const listCurrency = [
        { country: "United States", code: "en-US" ,initCode : 'US'},
        { country: "Canada", code: "en-CA" },
        { country: "United Kingdom", code: "en-GB" },
        { country: "Germany", code: "de-DE" },
        { country: "France", code: "fr-FR" },
        { country: "Japan", code: "ja-JP" },
        { country: "China", code: "zh-CN" },
        { country: "Spain", code: "es-ES" },
        { country: "Italy", code: "it-IT" },
        { country: "South Korea", code: "ko-KR" },
        { country: "Brazil", code: "pt-BR" },
        { country: "Russia", code: "ru-RU" },
        { country: "Saudi Arabia", code: "ar-SA" },
        { country: "Turkey", code: "tr-TR" },
        { country: "India", code: "hi-IN" },
        { country: "Philippines", code: "en-PH", initCode : 'PHP'},
    ];
    const number = parseInt(data);


    const data =  listCurrency.find((item) => {
        if(item.initCode === code.toUpperCase()){
            return number.toLocaleString(item.initCode, {
                style : 'currency',
                currency : item.initCode
            })
        }
    })


    return data;
};

export default currencyFormatter;
