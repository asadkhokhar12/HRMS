// Quick & dirty toggle to demonstrate modal toggle behavior
$('.modal-toggle').on('click', function(e) {
    console.log("asdfsafsadfsdaasdfasdf");
    e.preventDefault();
    $('.custom-modal').toggleClass('is-visible');
  });