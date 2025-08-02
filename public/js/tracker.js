(function () {
    const pageUrl = window.location.href;
    const trackingUrl = `http://web-tracker.test/api/track?page=${encodeURIComponent(window.location.href)}`;

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
