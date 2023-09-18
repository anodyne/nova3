import format from 'date-fns/format';
import formatISO from 'date-fns/formatISO';
import parseISO from 'date-fns/parseISO';

export default (value = '', dateFormat = 'M d, Y') => ({
    datePickerOpen: false,
    datePickerValue: value,
    datePickerDisplayValue: '',
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
        this.setDatePickerValue(selectedDate);
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
        return this.datePickerDisplayValue === this.datePickerFormatDate(d);
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
    },

    setDatePickerValue(date) {
        this.datePickerDisplayValue = this.datePickerFormatDate(date);
        this.datePickerValue = formatISO(date);

        this.$dispatch('input', this.datePickerValue);
    },

    init() {
        let currentDate = new Date();
        if (this.datePickerValue) {
            currentDate = parseISO(this.datePickerValue);
            this.setDatePickerValue(currentDate);
        }
        this.datePickerMonth = currentDate.getMonth();
        this.datePickerYear = currentDate.getFullYear();
        this.datePickerDay = currentDate.getDay();
        this.datePickerCalculateDays();
    },
});
