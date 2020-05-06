fetch(`${window.nova_app_url}/process-response`)
    .then(response => response.json())
    .then((data) => {
        if (data.dispatchQueue != null && data.dispatchQueue.length > 0) {
            data.dispatchQueue.forEach((event) => {
                const eventData = event.data ? event.data : {};
                const e = new CustomEvent(event.event, { bubbles: true, detail: eventData });
                const app = document.getElementById('app');

                app.dispatchEvent(e);
            });
        }
    });
