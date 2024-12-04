<div>
    <div class="bg-gray-50 px-4 border border-gray-400 my-2 rounded">
        <p>I write occasional emails about my ventures, thoughts, and discoveries. You'll get first news about launches, behind-the-scenes looks, and honest reflections on my journey - no automation, no fluff.</p>

        <form id="newsletter-subscription-form" class="flex flex-col gap-y-2" onsubmit="handleSubscribeToNewsletterFormSubmit(event)">
            <input
                class="border border-gray-400 rounded appearance-none py-1 px-2"
                type="email"
                name="email"
                id="email"
                required
                placeholder="Enter your email and subscribe to my newsletter"
            >
            <input
                type="text"
                name="honeypot"
                style="display:none !important"
                tabindex="-1"
                autocomplete="off"
            >
            <input
                type="hidden"
                name="timestamp"
                value="{{ time() }}"
            >
            <button id="newsletter-subscription-form-button" type="submit" class="bg-rose-600 text-white border border-gray-400 rounded appearance-none py-1 px-2">Subscribe</button>
            <div id="newsletter-subscription-form-message" class="mt-1 my-2"></div>
        </form>
    </div>

    <script>
        let isSubscribing = false;
        async function handleSubscribeToNewsletterFormSubmit(event) {
            event.preventDefault();
            if (isSubscribing) return;
            isSubscribing = true;
            document.getElementById('newsletter-subscription-form-button').innerText = 'Subscribing...'

            const form = event.target;
            const messageDiv = document.getElementById('newsletter-subscription-form-message');

            try {
                const response = await fetch('/newsletter/subscriptions', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        email: form.email.value,
                        honeypot: form.honeypot.value ?? '',
                        timestamp: form.timestamp.value
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    messageDiv.innerHTML = `<div class="text-green-600 font-medium">${data.message}</div>`;
                    form.reset();
                } else {
                    messageDiv.innerHTML = `<div class="text-orange-600 font-medium">${data.message}</div>`;
                }
            } catch (error) {
                console.log(error)
                messageDiv.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
            }

            document.getElementById('newsletter-subscription-form-button').innerText = 'Subscribe'
            isSubscribing = false
        }
    </script>
</div>
