
function updateFingerprint(fingerprint)
{
  if(fingerprint == null)
  {
    return;
  }
  part = document.getElementById("fingerprint");
  if(part == null)
  {
    return;
  }
  part.value = fingerprint;
  document.getElementById("submitButton").disabled = false;
}

const onFingerprintSet = new CustomEvent('OnFingerprintSet');
fingerpinrt = null;
console.log("starting")
// Initialize the agent at application startup.
const fpPromise = import('https://fpcdn.io/v3/dCePoiiehsErH9JIzs9T')
  .then(FingerprintJS => FingerprintJS.load());

// Get the visitor identifier when you need it.
fpPromise
  .then(fp => fp.get()
    .then(result => {
      // This is the visitor identifier:
      const visitorId = result.visitorId;
      $("body").append("<input type='hidden' id='fingerprint' name='fingerprint' value='" + visitorId + "'>");
      document.dispatchEvent(onFingerprintSet);
      console.log("Fired OnFingerprintSet event");
    }));
