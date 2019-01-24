<h1 id="login">Login</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>login.json</h4>
							</div>
							<!-- REQUEST RESPONSE FORMAT -->
							<div class="highlight boderleft">
								<h4 class="colorblue">Supported Formats</h4>  
								<code class="colorblue">JSON</code>
								<code class="colorblue">XML</code>
								<br><br>
								<p class="colorred">*Default Response is in JSON</p>
							</div>

							<!-- REQUEST METHOD -->
							<h3 id="type1">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input1">Input</h3>
							<div class="highlight boderleft">
								<pre >
									<code class="html">
{
    token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFpLmJyYWtlckBkYWlseWRvYy5jb20iLCJwYXNzd29yZCI6MTIzNDU2LCJidWlsZF92ZXJzaW9uIjoiMS4wLjAiLCJkZXZpY2VfdHlwZSI6MSwiZGV2aWNlX3Rva2VuIjoiNzgwMjc3M2I1YjNmNDZmNTQ2OTg1M2EyNjhhMGJiOGMxNDkzMjg3NTIyIn0.GZdJkAuUEo2oRp02oEVfSY8quXxli7jBOYWRLwQWKh4
}
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
									<p class="colorred">* No header is required.</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output1">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjp7ImlkIjoyNzUsImhvc3BpdGFsX2lkIjoxLCJwYXNzd29yZCI6IiQyeSQxMCRsLlR0d0NySjhnVVhpOVZjYlFtdEFlWjVicExiWWI5T0FBR054bjlidFhtU0MyY2FCenBDSyIsImVtYWlsIjoiYWkuYnJha2VyQGRhaWx5ZG9jLmNvbSIsImZpcnN0bmFtZSI6IkFpIiwibGFzdG5hbWUiOiJCcmFrZXIiLCJlbXBsb3llZV9yb2xlIjoiRG9jdG9yIiwiZGVzaWduYXRpb24iOiJDaGFpciBPZiBUaGUgRGVwYXJ0bWVudCIsImVtcGxveWVlX3JvbGVfc2hvcnQiOiJEUiIsImRlcGFydG1lbnQiOiJEZW50aXN0cnkiLCJ0aXRsZSI6IiIsInF1YWxpZmljYXRpb24iOiJNRCIsInBob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvZGVmYXVsdC5wbmciLCJvZmZpY2VfbnVtYmVyIjoiNjEyMjczMzA1NCIsImNlbGxfbnVtYmVyIjoiNjEyNjM2ODg1NCIsImZheF9udW1iZXIiOiI2MTIyNzUxMDU0IiwicGFnZXJfbnVtYmVyIjoiIiwid29ya2luZ190aW1lIjoiIiwiYXBwX3Rva2VuIjoiNTQ2YmI2NmExN2FmMmEyOGFjNDJmNWJkMjhiZmZlNzExNTM1MzY2NjAxIiwiaXNfd29ya2luZyI6MCwic3RhdHVzIjp0cnVlLCJpc19ub3RpZmljYXRpb24iOnRydWUsImhvc3BpdGFsc19lbXBsb3llZXMiOlt7ImVtcGxveWVlX2lkIjoyNzUsImhvc3BpdGFsX2lkIjotMSwic2VydmljZV90ZWFtX2lkIjotMX1dLCJwYXNzd29yZF9leHBpcmVkIjpmYWxzZSwiZGVwYXJ0bWVudF9pZCI6MTQwLCJlbXBsb3llZV9pZCI6Mjc1LCJkZXZpY2VfdG9rZW4iOiI3ODAyNzczYjViM2Y0NmY1NDY5ODUzYTI2OGEwYmI4YzE0OTMyODc1MjIiLCJkZXZpY2VfdHlwZSI6IjEiLCJidWlsZF92ZXJzaW9uIjoiMS4wLjAiLCJtb2RpZmllZCI6IjIwMTgtMDgtMjdUMDU6NDM6MjEtMDU6MDAiLCJwaG90b19uYW1lIjoiIiwicGhvdG9fdGh1bWIiOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyJ9fQ.XM-7XZucPWksL0Nn85ae4N5dewGW9gAdusWXn3s5Sg0"
}

									</code>
								</pre>
						 	</div>

						 	<br>

						 	<div class="bs-callout bs-callout-danger">
								<h4 class="colorred">Bad Response</h4>
								<pre style="background-color:inherit;border:none;">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMSwibWVzc2FnZSI6IkludmFsaWQgY3JlZGVudGlhbHMgaGF2ZSBiZWVuIHBhc3NlZC4ifQ.daLjqfFZJYL20IhKowBDX1Q6TXkv1WVxpygTtgG0z2k"
}
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjUwMCwibWVzc2FnZSI6IllvdXIgYWNjb3VudCBpcyBpbmFjdGl2ZS4gQ29udGFjdCBBZG1pbmlzdHJhdG9yLiJ9.6JBrHuD8Fne6M_1xFNf5yG8bv_AZ7IgPcnH7dBP_tto"
}
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6Ikluc3VmZmljaWVudCBwYXJhbWV0ZXJzIGhhdmUgYmVlbiBwYXNzZWQuIn0.IhFXlUKkD5uV0jTjPhHlaslSEGmtp5Fs-8ZFzOJg-6Y"
}
									<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>