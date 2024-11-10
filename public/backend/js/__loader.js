document.addEventListener('DOMContentLoaded', function () {
  const saveButton = document.querySelector('.loader-btn');
  const loader = document.getElementById('loader');

  saveButton.addEventListener('click', function () {
    loader.style.display = 'block'; // Show loader
    // Perform your form submission or other actions here
    // Once the action is complete, you can hide the loader
    // For example, you can use a setTimeout to simulate an action:
    setTimeout(function () {
      loader.style.display = 'none'; // Hide loader
    }, 2000); // Simulate a 2-second action
  });
});
