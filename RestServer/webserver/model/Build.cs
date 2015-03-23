using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using RestServer.webserver.items;
using MySql.Data.MySqlClient;
using System.Web.Script.Serialization;

namespace RestServer.webserver.model
{
    class Build : ServerMain
    {
        public Build(HttpListenerContext ctx, string[] splitUrl)
        {
            if (CheckAuth(ctx))
            {

            }
        }
    }
}
