(function () {
    const pageUrl = window.location.href;
    const trackingUrl = 'http://127.0.0.1:8000/api/track?page=' + encodeURIComponent(pageUrl);

    console.log("Sending visit to:", trackingUrl);

    const ipTracker = new Image();
    ipTracker.onload = function () {
        console.log("Tracker image request successful.");
    };
    ipTracker.onerror = function () {
        console.error("Tracker image request failed.");
    };
    ipTracker.src = trackingUrl;

    document.body.appendChild(ipTracker);
})();
