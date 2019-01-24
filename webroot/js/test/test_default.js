describe('default.js', function() {
    describe('sayHello', function() {
        it('1', function() {
            assert(sayHello() == 'hello');
        });
    });
    describe('sampleDate', function() {
        it('1', function() {
            var date = new Date('2018-11-11')
            var sample = sampleDate(date, 'YYYY/MM/DD')
            assert(sample == '2018/11/11');
        });
    });
});
