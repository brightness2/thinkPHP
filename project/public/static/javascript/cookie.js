var ZCookie = {
    get(name) {
        let arr,
            reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
        if ((arr = document.cookie.match(reg))) return unescape(arr[2]);
        else return null;
    },
    set(name, value, days = 30) {
        let Days = days;
        let exp = new Date();
        exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
        document.cookie =
            name + "=" + escape(value) + ";expires=" + exp.toGMTString();
    },
    delete(name) {
        let exp = new Date();
        exp.setTime(exp.getTime() - 1);
        let cval = ZCookie.get(name);
        if (cval != null)
            document.cookie =
                name + "=" + exp + ";expires=" + exp.toGMTString();
    },
};
