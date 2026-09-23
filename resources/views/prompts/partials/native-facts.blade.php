## Native facts

These were checked against the mobile-air source. Older docs and published agent skills get several of them wrong. If the clone disagrees with a line here, the clone wins; say so in your report.

**Calling native code from PHP.** `nativephp_call(string $method, string $params): ?string`. Parameters go in as a JSON string and the result comes back as a JSON string or null, not an array. PHP calls native directly; no JavaScript is involved.

**The JavaScript bridge** is only for webview screens (Livewire, Inertia and embedded `<native:webview>`). Native EDGE screens never use it.

**EDGE rendering.** PHP builds the element tree, which is sent to native through shared memory, not JSON over HTTP. Element classes (for example `BottomNav`) live in mobile-air under `src/Edge/Elements`. Their renderers (Compose on Android, SwiftUI on iOS) ship in mobile-ui. Without `nativephp/mobile-ui` registered, native screens render nothing and report no error.

**Routing.** `Route::native('/path', Screen::class)` registers a native screen. `Route::nativeGroup(Layout::class, fn)` applies a layout only to `Route::native()` routes inside it; plain `Route::get()` routes inside it are ordinary web routes. The app boots into native or webview mode depending on whether `NATIVEPHP_START_URL` resolves to a native route.

**Android bridge functions.** `BridgeError` is a sealed class with fixed subtypes (`InvalidParameters`, `ExecutionFailed`, `PermissionDenied`, `PermissionRequired`, `FunctionNotFound`, `UnknownError`); you throw them, you cannot construct `BridgeError("code", "msg")`. `BridgeResponse.error(code, message, data)` takes strings. `BridgeResponse.success(map)` returns the map unchanged. Array and object parameters arrive as `org.json.JSONArray` and `JSONObject`, so `as? List<*>` returns null. Bridge functions run off the main thread. Constructors take `FragmentActivity` by default or `Context` when the manifest's `android_params` says so.

**iOS bridge functions.** `BridgeResponse.success(data:)` and `.error(code:message:)`. `BridgeError` is an enum and throwing it is supported. Functions run off the main thread.

**Plugins.** Manifest is `nativephp.json`. Plugins must be registered in the app's `NativeServiceProvider::plugins()` (`php artisan native:plugin:register`) to be compiled in. Lifecycle hooks (`pre_compile`, `copy_assets`, `post_compile`, `post_build`) run as Artisan commands. Their output goes to the console only if the runner passes the command output through, and an Artisan command's `$this->output` is an `Illuminate\Console\OutputStyle`, which has `warning()` but no `warn()`, and no `$components`.

**Build commands.** `native:run`, `native:package` and `native:build` share the plugin compile and hook steps. A change there needs checking in all three. `native:watch` and `native:release` do not compile plugins.
