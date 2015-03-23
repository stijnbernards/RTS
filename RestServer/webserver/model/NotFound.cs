using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using RestServer.webserver.items;
using MySql.Data.MySqlClient;

namespace RestServer.webserver.model
{
    class NotFound : ServerMain
    {
        public NotFound(HttpListenerContext ctx)
        {
            string responseText = "{\"status\":\"404\"}";
            byte[] buf = Encoding.UTF8.GetBytes(responseText);

            ctx.Response.StatusCode = 404;
            ctx.Response.ContentEncoding = Encoding.UTF8;
            ctx.Response.ContentType = "application/json";
            ctx.Response.ContentLength64 = buf.Length;


            ctx.Response.OutputStream.Write(buf, 0, buf.Length);
            ctx.Response.Close();
        }
    }
}
