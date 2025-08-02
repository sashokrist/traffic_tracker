(function () {
    const pageUrl = window.location.href;
    const trackingUrl = `http://web-tracker.test/api/track?page=${encodeURIComponent(pageUrl)}`;

    console.log("Sending visit to:", trackingUrl);

    fetch(trackingUrl, {
        method: 'GET',
        mode: 'no-cors'
    })
        .then(() => {
            console.log("Tracker request sent.");
        })
        .catch((error) => {
            console.error("Tracker request failed:", error);
        });
})();
