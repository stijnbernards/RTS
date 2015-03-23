using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using System.Threading;
using RestServer.webserver;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;


namespace RestServer
{
    class Program
    {
        private static Dictionary<string, Delegate> commands = new Dictionary<string, Delegate>()
        {
            {"trymysql", (Action)(() => {
                MySqlConnection conn = new MySqlConnection() { ConnectionString = global.GlobalData.Connstring };
                try { conn.Open(); Console.WriteLine("Connection succesfully"); }
                catch (Exception e) { Console.WriteLine(e.Message); }
                finally { conn.Close(); }
            })},
        };

        static void Main(string[] args)
        {
            Webserver webserver = new Webserver();

            Thread command = new Thread(new ThreadStart(Command));
            command.Start();

        }

        private static void Command()
        {
            while (true)
            {
                string cmd = Console.ReadLine();
                try{commands[cmd].DynamicInvoke();}
                catch(Exception e){}
            }
        }
    }
}
