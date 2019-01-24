<h1 id="change_password">Change Password</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>changePassword.json</h4>
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
							<h3 id="type28">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input28">Input</h3>
							<div class="highlight boderleft">
								<pre >
									<code class="html">
user_token : "8942f8bec7f16962648b2f0f6d4dfb69ef43267b"
									</code>
									<p class="colorred">* HEADER PARAMETERS</p>
								</pre>
						 	</div>
						 	
							<div class="highlight boderleft">
								<pre >
									<code class="html">
{
    token:eyJhbGciOiJIUzI1NiJ9.eyJwYXNzd29yZCI6IkFkbWluQDEyMyIsImVtcGxveWVlX2lkIjoiMjc1IiwiY3VycmVudF9wYXNzd29yZCI6IjEyMzQ1NiJ9.re844d7zIHcWKkPK4ePjhD5C_n5kxjk0oKHmaV4hp9E
}
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output28">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IkNoYW5nZWQgcGFzc3dvcmQgc3VjY2Vzc2Z1bGx5LiJ9.PS8jX0_3NnRk_Fc1a1s1mVqJf-ag7wbpVf9RUEF9paM"
}

									</code>
								</pre>
						 	</div>

						 	<br>

						 	<div class="bs-callout bs-callout-danger">
								<h4 class="colorred">Bad Response</h4>
								<pre style="background-color:inherit;border:none;">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjUwMCwibWVzc2FnZSI6IlBsZWFzZSBlbnRlciBjb3JyZWN0IGN1cnJlbnQgcGFzc3dvcmQuIn0.a2FLz-OR7IvsJBoOdGcOG1kPvnvGP6Ytqc1LyoxB6NY"
}
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6Imluc3VmZmljaWVudCBwYXJhbWV0ZXJzIn0.HEqSL2ckJ8hlCAbLKIVYmzM2bdKkXKPbVNC3LsA5R7I"
}
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMywibWVzc2FnZSI6ImZvcmJpZGRlbiJ9.AvSXtHClYOacV0aDAJrERaLbWuvNcJZzMJuI_fhFcIA"
}
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjUwMCwibWVzc2FnZSI6IlBsZWFzZSBlbnRlciBjb3JyZWN0IGN1cnJlbnQgcGFzc3dvcmQuIn0.a2FLz-OR7IvsJBoOdGcOG1kPvnvGP6Ytqc1LyoxB6NY"
}
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjUwMCwibWVzc2FnZSI6IlVuYWJsZSB0byBwcm9jZXNzIHlvdXIgcmVxdWVzdCwgcGxlYXNlIHRyeSBhZnRlciBzb21ldGltZS4ifQ.GGEuKBE5RLgPukB_t1nEFXGbX_qiZ2dFEoiYh9BF-PE"
}


									<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>