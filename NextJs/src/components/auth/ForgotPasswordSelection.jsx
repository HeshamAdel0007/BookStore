import BackgroundImage from '@/../public/assets/images/sativa.png'
import AdminImage from '@/../public/assets/images/admin.png'
import PublisherImage from '@/../public/assets/images/vendor.png'
import CustomerImage from '@/../public/assets/images/user_icon.png'
import Selections from './Selections'

const ForgotPasswordSelection = () => {
  return (
    <section
      className="w-screen h-screen grid place-content-center"
      style={{
        backgroundImage: `url(${BackgroundImage.src})`,
      }}
    >
      <div className="bg-white shadow-md w-auto rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
        <div className="px-3">
          <h3
            style={{
              fontFamily: `Cairo, sans-serif`,
              color: `black`,
              fontWeight: `bolder`,
            }}
            className="mb-30"
          >
            Login As ....
          </h3>
          <div className="flex">
            <Selections
              Name={'forgot'}
              Linkhref={'admin'}
              ImageSrc={AdminImage}
              ImgAlt={'admin'}
            />

            <Selections
              LinkClass={'mx-11'}
              Name={'forgot'}
              Linkhref={'publisher'}
              ImageSrc={PublisherImage}
              ImgAlt={'publisher'}
            />

            <Selections
              Name={'forgot'}
              Linkhref={'customer'}
              ImageSrc={CustomerImage}
              ImgAlt={'customer'}
            />
          </div>
        </div>
      </div>
    </section>
  )
}

export default ForgotPasswordSelection
