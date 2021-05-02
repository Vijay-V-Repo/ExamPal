const sleep = (milliseconds) => {
    return new Promise(resolve => setTimeout(resolve, milliseconds))
}

function wordToNumber(str) {
    let units = ['PLACEHOLDER', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];

    let tens = ['PLACEHOLDER', 'PLACEHOLDER', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

    let flag = false

    tens.forEach((ten, index) => {
        if (str.includes(ten)) {
            units.forEach((unit, i) => {
                if (str.includes(unit)) {
                    str = str.replace(ten + ' ' + unit, index.toString() + i.toString())
                    flag = true
                }
            })
            if (!flag) {
                str = str.replace(ten, index + '0')
            }
            flag = true
            return;
        }
    })

    if (!flag) {
        units.forEach((unit, i) => {
            if (str.includes(unit)) {
                str = str.replace(unit, i.toString());
                return;
            }
        });
    }

    return str
}