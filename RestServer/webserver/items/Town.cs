using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace RestServer.webserver.items
{
    class Town
    {
        public int ID { get; set; }
        public int Owner_ID { get; set; }
        public string Coords { get; set; }
        public int Res1 { get; set; }
        public int Res2 { get; set; }
        public int Res3 { get; set; }
        public int Troops { get; set; }
        public string Buildings { get; set; }
        public string Name { get; set; }
    }
}
