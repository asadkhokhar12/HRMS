function formatTimeDifference(oldTime) {
  const oldDate = new Date(oldTime);
  const currentDate = new Date();
  const timeDifference = currentDate - oldDate;
  // Calculate the time difference in seconds, minutes, hours, days, months, and years
  const seconds = Math.floor(timeDifference / 1000);
  const minutes = Math.floor(seconds / 60);
  const hours = Math.floor(minutes / 60);
  const days = Math.floor(hours / 24);
  const months = Math.floor(days / 30);
  const years = Math.floor(months / 12);

  // Calculate the remaining values
  const remainingMonths = months % 12;
  const remainingDays = days % 30;
  const remainingHours = hours % 24;
  const remainingMinutes = minutes % 60;

  // Build the formatted string
  let formattedTime = "";
  if (years > 0) {
    formattedTime += `${years} year${years > 1 ? "s" : ""} `;
  }
  if (remainingMonths > 0) {
    formattedTime += `${remainingMonths} month${
      remainingMonths > 1 ? "s" : ""
    } `;
  }
  if (remainingDays > 0) {
    formattedTime += `${remainingDays} day${remainingDays > 1 ? "s" : ""} `;
  }
  if (remainingHours > 0) {
    formattedTime += `${remainingHours} hour${remainingHours > 1 ? "s" : ""} `;
  }
  if (remainingMinutes > 0) {
    formattedTime += `${remainingMinutes} minute${
      remainingMinutes > 1 ? "s" : ""
    } `;
  }
  formattedTime += "ago";
  return formattedTime.trim();
}

function formatDateTime(dateTimeString) {
  const options = {
    year: "numeric",
    month: "short",
    day: "numeric",
    hour: "numeric",
    minute: "numeric",
    hour12: true,
  };

  const date = new Date(dateTimeString);
  const formattedDate = date.toLocaleString("en-US", options);
  const day = date.getDate();
  const daySuffix = getDaySuffix(day);
  const formattedDateWithSuffix = formattedDate.replace(
    day.toString(),
    day + daySuffix
  );

  return formattedDateWithSuffix;
}

function getDaySuffix(day) {
  if (day >= 11 && day <= 13) {
    return "th";
  }
  switch (day % 10) {
    case 1:
      return "st";
    case 2:
      return "nd";
    case 3:
      return "rd";
    default:
      return "th";
  }
}
