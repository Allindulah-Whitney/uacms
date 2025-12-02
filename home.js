// Placeholder for future enhancements
console.log("Homepage loaded successfully.");
fetch(githubRawURL)
    .then(response => response.text())
    .then(jsonString => {
        // Format JSON cleanly
        try {
            const parsed = JSON.parse(jsonString);
            jsonString = JSON.stringify(parsed, null, 4);
        } catch (e) {
            // If it's not valid JSON, show raw text
        }

        document.getElementById("code-block").textContent = jsonString;
        hljs.highlightAll();
    });
