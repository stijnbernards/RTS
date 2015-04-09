using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using System.IO;
using System.Xml;
using System.Reflection;
using System.Data;
using MySql.Data.MySqlClient;
using RestServer.global;

namespace RestServer.webserver
{
    class ServerMain
    {

        public T GetPost<T>(HttpListenerRequest request) where T : new()
        {
            var result = new T();

            Stream body = request.InputStream;
            Encoding encoding = request.ContentEncoding;
            StreamReader reader = new StreamReader(body, encoding);

            string data = reader.ReadToEnd();
            body.Close();
            reader.Close();

#if DEBUG
            Console.WriteLine(data);
#endif
            //Array containing var=val
            string[] varData = data.Split('&');

            foreach (string var in varData)
            {
                string varName = var.Split('=')[0];
                string varValue = var.Split('=')[1];

                PropertyInfo propInfo = result.GetType().GetProperty(varName);

                propInfo.SetValue(result, varValue, null);
            }

            return result;
        }

        public bool CheckAuth(HttpListenerContext ctx)
        {
            bool auth = false;
            string responseText = "";
#if DEBUG
            Console.WriteLine(ctx.Request.Headers["hash"]);
            auth = true;
#else
            if (Sessions.ConnectedUsers.Keys.Contains(ctx.Request.Headers["hash"]))
            {
                auth = true;
            }
            else
            {
                responseText = "{\"status\":\"Not authorized\"}";
                byte[] buf = Encoding.UTF8.GetBytes(responseText);

                ctx.Response.ContentEncoding = Encoding.UTF8;
                ctx.Response.ContentType = "application/json";
                ctx.Response.ContentLength64 = buf.Length;

                ctx.Response.OutputStream.Write(buf, 0, buf.Length);
                ctx.Response.Close();
            }
#endif
            return auth;
        }
    }
}
