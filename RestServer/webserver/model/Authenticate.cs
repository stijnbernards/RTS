using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using RestServer.webserver.items;
using MySql.Data.MySqlClient;

namespace RestServer.webserver.model
{
    class Authenticate : ServerMain
    {
        public Authenticate(HttpListenerContext ctx, string[] splitUrl)
        {
            bool authenticated = false;
            int userID = 0;
            User data = GetPost<User>(ctx.Request);

            Tuple<string, string>[] parameters = { 
                                                     new Tuple<string, string>("@uname", data.username), 
                                                     new Tuple<string, string>("@pass", data.password) 
                                                 };

            MySqlDataReader reader = RestServer.global.GlobalFunctions.Query("SELECT `ID` FROM `users` WHERE `username` = @uname AND `password` = @pass", parameters);
            while (reader.Read())
            {
                authenticated = true;
                userID = reader.GetInt32(0);
            }

#if DEBUG
            Console.WriteLine(userID);
            Console.WriteLine(authenticated);
            Console.WriteLine(data.username);
            Console.WriteLine(data.password);
#endif
            string responseText;
            if (authenticated)
            {
                string Guid = System.Guid.NewGuid().ToString();
                responseText = "{\"hash\":\"" + Guid + "\"}";

                Sessions.ConnectedUsers.Add(Guid, userID);
            }
            else
            {
                responseText = "{\"response\":\"Wrong username or password\"}";
                ctx.Response.StatusCode = 403;
            }
            byte[] buf = Encoding.UTF8.GetBytes(responseText);

            ctx.Response.ContentEncoding = Encoding.UTF8;
            ctx.Response.ContentType = "application/json";
            ctx.Response.ContentLength64 = buf.Length;

            ctx.Response.OutputStream.Write(buf, 0, buf.Length);
            ctx.Response.Close();
        }
    }
}
