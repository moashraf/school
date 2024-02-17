
    // Function to get the current date and the week's dates
//     function getWeekDates_old() {
//      const weekDates = [];
//
//     // Starting from Sunday (0) to Saturday (6)
//     for (let i = 0; i < 7; i++) {
//     const date = new Date();
//     date.setDate(date.getDate() - date.getDay() + i);
//     weekDates.push(date);
// }
//
//     return weekDates;
// }

    function getWeekDates() {
        const weekDates = [];

        // Get the current date
        const currentDate = new Date();

        // Loop for the next 7 days, starting from today
        for (let i = 0; i < 7; i++) {
            const date = new Date(currentDate);
            date.setDate(currentDate.getDate() + i); // Add 'i' days to the current date
            weekDates.push(date);
        }

        return weekDates;
    }



    // Function to create a select element with options for each day of the week
    function createSelectElement(dates) {
    const select = document.createElement('select');
    select.className = 'js-example-basic-single select2-no-search select2-hidden-accessible';
        select.setAttribute('name', 'meetings_date[]');

    dates.forEach((date, index) => {
    const option = document.createElement('option');
 //   option.value = index + 1;
        option.value = `${date.toLocaleDateString()} ${date.toLocaleDateString('ar-EG', { weekday: 'long' })}`;
    option.textContent = `${date.toLocaleDateString()} ${date.toLocaleDateString('ar-EG', { weekday: 'long' })}`;
    select.appendChild(option);
});

    return select;
}

    // Main function to generate the select elements and append them
    function generateSelectElements() {
    const weekDates = getWeekDates();
    const container = document.getElementById('select-container');

    // Repeat 4 times

    const selectElement = createSelectElement(weekDates);
    container.appendChild(selectElement);
    container.appendChild(document.createElement('br')); // For better spacing

}


