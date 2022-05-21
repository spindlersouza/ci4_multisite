const mp = new MercadoPago('TEST-c95303fa-246f-4452-bde3-f128ca706a6c');
//const mp = new MercadoPago('APP_USR-76ebbf7d-27e9-4139-8fa9-a9ddba08deb0');
const cardForm = mp.cardForm({
    amount: document.getElementById('total_carrinho').value,
    autoMount: true,
    form: {
        id: "form-checkout",
        cardholderName: {id: "form-checkout__cardholderName", placeholder: "Titular do cartão", },
        cardholderEmail: {id: "form-checkout__cardholderEmail", placeholder: "E-mail", },
        cardNumber: {id: "form-checkout__cardNumber", placeholder: "Número do cartão", },
        cardExpirationDate: {id: "form-checkout__cardExpirationDate", placeholder: "Data de vencimento (MM/YYYY)", },
        securityCode: {id: "form-checkout__securityCode", placeholder: "Código de segurança", },
        installments: {id: "form-checkout__installments", placeholder: "Parcelas", },
        identificationType: {id: "form-checkout__identificationType", placeholder: "Tipo de documento", },
        identificationNumber: {id: "form-checkout__identificationNumber", placeholder: "Número do documento", },
        issuer: {id: "form-checkout__issuer", placeholder: "Banco emissor", },
    },
    callbacks: {
        onFormMounted: error => {
            if (error) {
                return console.warn('Form Mounted handling error: ', error);
            }
//            console.log('Form mounted');
        },
        onFormUnmounted: error => {
            if (error) {
                return console.warn('Form Unmounted handling error: ', error);
            }
//            console.log('Form unmounted');
        },
        onIdentificationTypesReceived: (error, identificationTypes) => {
            if (error) {
                return console.warn('identificationTypes handling error: ', error);
            }
//            console.log('Identification types available: ', identificationTypes);
        },
        onPaymentMethodsReceived: (error, paymentMethods) => {
            if (error) {
                return console.warn('paymentMethods handling error: ', error);
            }
//            console.log('Payment Methods available: ', paymentMethods);
        },
        onIssuersReceived: (error, issuers) => {
            if (error) {
                return console.warn('issuers handling error: ', error);
            }
//            console.log('Issuers available: ', issuers);
        },
        onInstallmentsReceived: (error, installments) => {
            if (error) {
                return console.warn('installments handling error: ', error);
            }
//            console.log('Installments available: ', installments);
        },
        onCardTokenReceived: (error, token) => {
            if (error) {
                return console.warn('Token handling error: ', error);
            }
//            console.log('Token available: ', token);
        },
        onSubmit: (event) => {
            event.preventDefault();
            const cardData = cardForm.getCardFormData();
            
            fetch("/api/mp/pagamentocc", {
                method: "POST",
                headers: {"Content-Type": "application/json", },
                body: JSON.stringify(cardData)
            }).then(function(response){
                var rp = $.parseJSON(response);
                if(rp.error != ''){
                    location.reload();
                } else {
                    localtion.href = 'meus-pedidos';
                }
                console.log(response);
            }).catch(function(error){
                location.reload();
            });

//            console.log('CardForm data available: ', cardData);
        },
        onFetching: (resource) => {
            console.log('Fetching resource: ', resource);

            // Animate progress bar
            const progressBar = document.querySelector('.progress-bar');
            progressBar.removeAttribute('value');

            return () => {
                progressBar.setAttribute('value', '0');
            };
        },
    }

});