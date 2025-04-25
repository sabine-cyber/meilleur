function launchPayment(amount) {
    fetch('/create_payment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'amount=' + encodeURIComponent(amount)
    })
    .then(response => response.json())
    .then(data => {
        if (data.url) {
            window.location.href = data.url; // redirection vers la page de paiement
        } else {
            alert('Erreur lors de la création du paiement.');
            console.error(data);
        }
    })
    .catch(error => {
        alert('Erreur réseau.');
        console.error('Erreur :', error);
    });
}
