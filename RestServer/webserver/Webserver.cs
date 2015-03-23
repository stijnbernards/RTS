using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using System.Threading;
using RestServer.webserver.model;

namespace RestServer.webserver
{
    class Webserver
    {
        public Webserver()
        {
            HttpListener listener = new HttpListener();
            listener.Prefixes.Add("http://*:80/");
            listener.Start();

            new Thread(
                () =>
                {
                    while (true)
                    {
                        HttpListenerContext ctx = listener.GetContext();
                        ThreadPool.QueueUserWorkItem((_) => ProcessRequest(ctx));
                    }
                }
            ).Start();
        }

        private void ProcessRequest(HttpListenerContext ctx)
        {
            Console.WriteLine("Requested url: " + ctx.Request.Url);
            try
            {
                string[] splitUrl = ctx.Request.Url.ToString().Split('/');
                Activator.CreateInstance(Type.GetType("RestServer.webserver.model." + splitUrl[3]), ctx, splitUrl);
            }
            catch (Exception e)
            {
                new NotFound(ctx);
            }
        }
    }
}
