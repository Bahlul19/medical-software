function Bezier(...arg){
    this.value = [0,...arg,1]
    this.pointList = []
}




Bezier.prototype = {
    _generate(t){
        var value = 0
        var n = this.value.length-1
        for(let i = 0 ;i<this.value.length;i++){
            value += Math.pow((1.0-t),n-i)*Math.pow(parseFloat(t),i)*this.value[i]*(1)*(this._C(n,i))
        }
        return value
    },
    generatePoints(n){
        var _this = this
        for(let i = 0 ;i<n;i++){
            this.pointList.push({
                x:(i/parseFloat(n-1)),
                y:_this._generate((i/parseFloat(n-1)))
            })

        }
    },
    _C(m,n){
        return this._Factorial(m)/(this._Factorial(n)*this._Factorial(m-n))
    },
    _Factorial(x){
        if (x < 2) {
            return 1
        } else {
            var value = 1
            for(let i = 1;i<=x;i++){
                value *= i
            }
            return value
        }
    }
}

module.exports = Bezier