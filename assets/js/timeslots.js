const duration1 =  document.getElementById('duration_1');
const duration2 =  document.getElementById('duration_2');
const timeslot1 =  document.getElementById('timeslot_1');
const timeslot2 =  document.getElementById('timeslot_2');

timeslot2.style.display = 'none';

duration1.addEventListener('click', function() {
    timeslot1.style.display = 'block';
    timeslot2.style.display = 'none';
});
duration2.addEventListener('click', function() {
        timeslot1.style.display = 'none';
        timeslot2.style.display = 'block';
    }
);
