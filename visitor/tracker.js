async function getVisitData() {
    try {

        let response = await fetch('https://api.ipgeolocation.io/ipgeo?apiKey=');
        let data = await response.json();

        let ip = data.ip;
        let city = data.city;
        let device = navigator.userAgent;

        fetch('track.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ ip, city, device })
        });
    } catch (error) {
        console.error('Error:', error);
    }
}

window.onload = getVisitData;
