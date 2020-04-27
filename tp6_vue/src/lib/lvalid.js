class lvalid{
    static valid() {
        let  el = document.getElementsByClassName("lvalid");
        for(let  i = 0; i < el.length; i++){
            if(el[i].getAttribute("required") === "required"){
                if(this.isNull(el[i].value)){
                    return el[i].getAttribute("info");
                }
            }
            if(el[i].getAttribute("valid") === "int"){
                if(!this.isInt(el[i].value) && !isNull(el[i].value)){
                    return el[i].getAttribute("validInfo");
                }
            }
            if(el[i].getAttribute("valid") === "number" && !isNull(el[i].value)){
                if(!this.isNumber(el[i].value)){
                    return el[i].getAttribute("validInfo");
                }
            }
            if(el[i].getAttribute("valid") === "decimal" && !isNull(el[i].value)){
                if(!this.isDecimal(el[i].value)){
                    return el[i].getAttribute("validInfo");
                }
            }
            if(el[i].getAttribute("valid") === "mobile" && !isNull(el[i].value)){
                if(!this.isMobile(el[i].value)){
                    return el[i].getAttribute("validInfo");
                }
            }
            if(el[i].getAttribute("valid") === "phone" && !isNull(el[i].value)){
                if(!this.isPhone(el[i].value)){
                    return el[i].getAttribute("validInfo");
                }
            }
            if(el[i].getAttribute("valid") === "email" && !isNull(el[i].value)){
                if(!this.isEmail(el[i].value)){
                    return el[i].getAttribute("validInfo");
                }
            }
            if(el[i].getAttribute("valid") === "tel" && !isNull(el[i].value)){
                if(!this.isTel(el[i].value)){
                    return el[i].getAttribute("validInfo");
                }
            }
        }
        return true;
    }
    static getValue() {
        let  validResult = this.valid();
        if(validResult === true){
            let  el = document.getElementsByClassName("lvalid");
            let  data = {};
            for(let  i = 0; i < el.length; i++){
                data[el[i].getAttribute("id")] = el[i].value;
            }
            return data;
        }else{
            return validResult;
        }
    }

    /*
    用途：检查输入字符串是否为空或者全部都是空格
    输入：str
    返回：
    如果全是空返回true,否则返回false
     */
    static isNull(str) {
        if(str === 0){
            return false;
        }
        if (str === "" || str === null || str === undefined){
            return true;
        }
        let  regu = "^[ ]+$";
        let  re = new RegExp(regu);
        return re.test(str);
    }

    /**
     * 判断用户名格式，包含大小写英文、数字和下划线。同时用户名长度在6-15之间。
     */
    static isUsername(username) {
        let  first = username.substring(0, 1);
        if (!((first >= 'a' && first <= 'z') || (first >= 'A' && first <= 'Z'))) {
            return false;
        }
        let  rename = new RegExp("[a-zA-Z_][a-zA-Z_0-9]{0,}", "");
        return rename.test(username);
    }

    /**
     * 判断密码格式，包含大小写英文、数字和下划线。同时用户名长度在6-16之间。
     */
    static isPassword(password) {
        let  regex = /^[0-9A-Za-z_]{6,16}$/;
        return regex.test(password);
    }


    /*
     * 用途：检查输入字符串是否只由汉字、字母 输入： value：字符串 返回： 如果通过验证返回true,否则返回false
     *
     */
    static isRealName(s) {// 判断是否是汉字、字母

        let  regu = "^[a-zA-Z\u4e00-\u9fa5]+$";
        let  re = new RegExp(regu);
        return re.test(s);
    }

    /*
     * 用途：检查输入的Email信箱格式是否正确 输入： strEmail：字符串 返回： 如果通过验证返回true,否则返回false
     *
     */
    static isEmail(strEmail) {
        // let  emailReg = /^[_a-z0-9]+@([_a-z0-9]+\.)+[a-z0-9]{2,3}$/;
        let  emailReg = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
        return emailReg.test(strEmail);
    }

    /*
     * 用途：检查输入对象的值是否符合整数格式 输入：str 输入的字符串 返回：如果通过验证返回true,否则返回false
     *
     */
    static isNumber(str) {
        let  regu = /^[-]{0,1}[0-9]{1,}$/;
        return regu.test(str);
    }

    /*
     * 用途：检查输入字符串是否符合正整数格式 输入： s：字符串 返回： 如果通过验证返回true,否则返回false
     *
     */
    static isInt(s) {
        if(s === null || s === undefined){
            return false;
        }
        let  regu = "^[0-9]+$";
        let  re = new RegExp(regu);
        return s.search(re) !== -1;
    }

    /*
     * 用途：检查输入字符串是否是带小数的数字格式,可以是负数 输入： s：字符串 返回： 如果通过验证返回true,否则返回false
     *
     */
    static isDecimal(str) {
        if (this.isNumber(str))
            return true;
        let  re = /^[-]{0,1}(\d+)[\.]+(\d+)$/;
        if (re.test(str)) {
            return !(RegExp.$1 === 0 && RegExp.$2 === 0);

        } else {
            return false;
        }
    }

    /*
     * 用途：检查输入手机号码是否正确 输入： s：字符串 返回： 如果通过验证返回true,否则返回false
     *
     */
    static isMobile(s) {
        let  length = s.length;
        if(length !== 11){
            return false;
        }
        let  first = s.charAt(0);
        return first === 1;

    }


    static checkMobile(s) {
        var regu = /^[1][3|4|5|8][0-9]{9}$/;
        var re = new RegExp(regu);
        if (re.test(s)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * 用途：检查输入的电话号码格式是否正确 输入： strPhone：字符串 返回： 如果通过验证返回true,否则返回false
     *
     */
    static isPhone(strPhone) {
        let  phoneRegWithArea = /^[0][1-9]{2,3}-[0-9]{5,10}$/;
        let  phoneRegNoArea = /^[1-9]{1}[0-9]{5,8}$/;
        if (strPhone.length > 9) {
            return phoneRegWithArea.test(strPhone);
        } else {
            return phoneRegNoArea.test(strPhone);

        }
    }

    /**
     * 验证手机号+座机号
     * @param s
     * @returns {boolean}
     */
    static isTel(s) {
        if(this.isMobile(s)){
            return true;
        }
        return this.isPhone(s);

    }

    /**
     * 获得年月日的日期格式
     * @param val
     * @returns {string}
     */
    static formatDate (val) {
        let date = new Date(val);
        let seperator1 = "-";
        let year = date.getFullYear();
        let month = date.getMonth() + 1;
        let strDate = date.getDate();
        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }
        let currentdate = year + seperator1 + month + seperator1 + strDate;
        return currentdate;
    }

    /**
     * 当前日期增加一年
     * @param val
     * @returns {string}
     */
    static modifyDate(val) {
        let date = new Date(val);
        let seperator1 = "-";
        let year = date.getFullYear()+1;
        let month = date.getMonth();
        let strDate = date.getDate();
        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }
        let currentdate = year + seperator1 + month + seperator1 + strDate;
        return currentdate;
    }

}
export default lvalid;