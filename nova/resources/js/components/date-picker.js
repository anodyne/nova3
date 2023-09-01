import format from 'date-fns/format';

export default (value = '', dateFormat = 'M d, Y') => ({
    datePickerOpen: false,
    datePickerValue: value,
    datePickerFormat: dateFormat,
    datePickerMonth: '',
    datePickerYear: '',
    datePickerDay: '',
    datePickerDaysInMonth: [],
    datePickerBlankDaysInMonth: [],
    datePickerMonthNames: [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
    ],
    datePickerDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

    datePickerDayClicked(day) {
        const selectedDate = new Date(
            this.datePickerYear,
            this.datePickerMonth,
            day,
        );
        this.datePickerDay = day;
        this.datePickerValue = this.datePickerFormatDate(selectedDate);
        this.datePickerIsSelectedDate(day);
        this.datePickerOpen = false;
    },

    datePickerPreviousMonth() {
        if (this.datePickerMonth === 0) {
            this.datePickerYear -= 1;
            this.datePickerMonth = 12;
        }
        this.datePickerMonth -= 1;
        this.datePickerCalculateDays();
    },

    datePickerNextMonth() {
        if (this.datePickerMonth === 11) {
            this.datePickerMonth = 0;
            this.datePickerYear += 1;
        } else {
            this.datePickerMonth += 1;
        }
        this.datePickerCalculateDays();
    },

    datePickerIsSelectedDate(day) {
        const d = new Date(this.datePickerYear, this.datePickerMonth, day);
        return this.datePickerValue === this.datePickerFormatDate(d);
    },

    datePickerIsToday(day) {
        const today = new Date();
        const d = new Date(this.datePickerYear, this.datePickerMonth, day);
        return today.toDateString() === d.toDateString();
    },

    datePickerCalculateDays() {
        const daysInMonth = new Date(
            this.datePickerYear,
            this.datePickerMonth + 1,
            0,
        ).getDate();
        // find where to start calendar day of week
        const dayOfWeek = new Date(
            this.datePickerYear,
            this.datePickerMonth,
        ).getDay();
        const blankdaysArray = [];
        for (let i = 1; i <= dayOfWeek; i++) {
            blankdaysArray.push(i);
        }
        const daysArray = [];
        for (let i = 1; i <= daysInMonth; i++) {
            daysArray.push(i);
        }
        this.datePickerBlankDaysInMonth = blankdaysArray;
        this.datePickerDaysInMonth = daysArray;
    },

    datePickerFormatDate(date) {
        return format(date, this.datePickerFormat);

        const formattedDay = this.datePickerDays[date.getDay()];
        const formattedDate = (`0${date.getDate()}`).slice(-2); // appends 0 (zero) in single digit date
        const formattedMonth = this.datePickerMonthNames[date.getMonth()];
        const formattedMonthShortName = this.datePickerMonthNames[
            date.getMonth()
        ].substring(0, 3);
        const formattedMonthInNumber = (
            `0${parseInt(date.getMonth(), 10) + 1}`
        ).slice(-2);
        const formattedYear = date.getFullYear();

        if (this.datePickerFormat === 'M d, Y') {
            return `${formattedMonthShortName} ${formattedDate}, ${formattedYear}`;
        }
        if (this.datePickerFormat === 'MM-DD-YYYY') {
            return `${formattedMonthInNumber}-${formattedDate}-${formattedYear}`;
        }
        if (this.datePickerFormat === 'DD-MM-YYYY') {
            return `${formattedDate}-${formattedMonthInNumber}-${formattedYear}`;
        }
        if (this.datePickerFormat === 'YYYY-MM-DD') {
            return `${formattedYear}-${formattedMonthInNumber}-${formattedDate}`;
        }
        if (this.datePickerFormat === 'D d M, Y') {
            return `${formattedDay} ${formattedDate} ${formattedMonthShortName} ${formattedYear}`;
        }

        return `${formattedMonth} ${formattedDate}, ${formattedYear}`;
    },

    init() {
        let currentDate = new Date();
        if (this.datePickerValue) {
            currentDate = new Date(Date.parse(this.datePickerValue));
        }
        this.datePickerMonth = currentDate.getMonth();
        this.datePickerYear = currentDate.getFullYear();
        this.datePickerDay = currentDate.getDay();
        this.datePickerCalculateDays();
    },
});
