const Ziggy = {"url":"http:\/\/zero2one_coding_challenge.test","port":null,"defaults":{},"routes":{"auth.create":{"uri":"login","methods":["GET","HEAD"]},"auth.store":{"uri":"login","methods":["POST"]},"auth.destroy":{"uri":"logout","methods":["POST"]},"dashboard.index":{"uri":"dashboard","methods":["GET","HEAD"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
